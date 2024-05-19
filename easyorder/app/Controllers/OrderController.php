<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class OrderController extends BaseController
{
    protected $db;

    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views in the OrderController
        helper('url'); 

        $this->session = session();
        $this->db = \Config\Database::connect();
    }

    /**
     * Display the home page with user's active orders and dashboards.
     *
     */
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $userModel = new \App\Models\UserModel();
        $orderModel = new \App\Models\OrderModel();
        $tableModel = new \App\Models\TablesModel();
        $orderItemModel = new \App\Models\OrderitemModel();
        $menuModel = new \App\Models\MenuModel();

        $data['user'] = $userModel->find($user_id);
        $data['activeOrders'] = $orderModel->where('user_id', $user_id)->where('order_status', 'active')->findAll();

        foreach ($data['activeOrders'] as &$order) {
            $order['table'] = $tableModel->find($order['table_id']);
            $orderItems = $orderItemModel->where('order_id', $order['order_id'])->findAll();
            //Display the first item for better identification for user.
            $order['first_item'] = $menuModel->find($orderItems[0]['menu_item_id'])['item_name'] ?? '';
        }

        return view('home', $data);
    }

    /**
     * Display the menu edit page with user's menu items and categories.
     */
    public function menuedit()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $menuModel = new \App\Models\MenuModel();
        $categoryModel = new \App\Models\CategoryModel();

        $search = $this->request->getGet('search');

        $data['categories'] = $categoryModel->where('user_id', $user_id)->findAll();
        $data['menuitems'] = $this->searchAndJoinCategory($user_id, $search, $menuModel);
        $data['search'] = $search;

        return view('menuedit', $data);
    }

    /**
     * The full display and search base function.
     * Includng join menu items with their respective categories, 
     * and initiate the search function base.
     *
     * @param int|null $user_id The user ID to filter menu items.
     * @param string|null $search The search keyword for menu items.
     * @param object $menuModel The instance of the MenuModel.
     * @return array The array of menu items with joined category information.
     */
    private function searchAndJoinCategory($user_id = null, $search = null, $menuModel)
    {
        //Join the Menuitem and Category table for better fetch and display.
        $builder = $menuModel->builder();
        $builder->select('Menuitem.*, Category.category_name, Category.category_sort');
        $builder->join('Category', 'Category.category_id = Menuitem.category_id', 'left');

        //Only display menu items with current user.
        if ($user_id !== null) {
            $builder->where('Menuitem.user_id', $user_id);
        }

        //Allowed search fields are item name, description and category.
        if ($search !== null) {
            $builder->groupStart();
            $builder->like('Menuitem.item_name', $search);
            $builder->orLike('Menuitem.description', $search);
            $builder->orLike('Category.category_name', $search);
            $builder->groupEnd();
        }

        //Sort by category sequence first, then price in ascending order.
        $builder->orderBy('Category.category_sort', 'asc');
        $builder->orderBy('Menuitem.price', 'asc');

        $query = $builder->get();
        return $query->getResultArray();
    }

    /**
     * Display the add/edit category page.
     *
     * @param int|null $category_id The category ID to edit (optional).
     * @return void
     */
    public function addeditCategory($category_id = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $categoryModel = new \App\Models\CategoryModel();

        $data = [];

        if ($category_id) {
            $category = $categoryModel->find($category_id);
            if (!$category) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
            }
            $data['category'] = $category;
        }

        return view('addcategory', $data);
    }
    
    /**
     * Save a category (add or update).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function attemptSaveCategory()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }
    
        $user_id = session()->get('user_id');
        $categoryModel = new \App\Models\CategoryModel();
    
        $category_id = $this->request->getPost('category_id');
    
        $data = [
            'user_id' => $user_id,
            'category_name' => $this->request->getPost('category_name'),
            'category_sort' => $this->request->getPost('category_sort')
        ];
    
        if ($category_id) {
            $categoryModel->update($category_id, $data);
            session()->setFlashdata('success', 'Category updated successfully.');
        } else {
            $categoryModel->insert($data);
            session()->setFlashdata('success', 'Category added successfully.');
        }
    
        return redirect()->to('/menuedit');
    }
    
    /**
     * Delete a category.
     *
     * @param int $category_id The category ID to delete.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deleteCategory($category_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $categoryModel = new \App\Models\CategoryModel();

        $category = $categoryModel->find($category_id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $categoryModel->delete($category_id);
        log_message('debug', 'Category deleted successfully.');
        session()->setFlashdata('success', 'Category deleted successfully.');

        return redirect()->to('/menuedit');
    }   

    /**
     * Display the add/edit item page.
     *
     * @param int|null $item_id The item ID to edit (optional).
     * @return void
     */
    public function addeditItem($item_id = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $menuModel = new \App\Models\MenuModel();
        $categoryModel = new \App\Models\CategoryModel();

        $data = [];

        if ($item_id) {
            $item = $menuModel->find($item_id);
            if (!$item) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
            }
            $data['item'] = $item;
        }

        $data['categories'] = $categoryModel->where('user_id', $user_id)->findAll();
        return view('additem', $data);
    }

    /**
     * Save an item (add or update).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function attemptSaveItem()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $menuModel = new \App\Models\MenuModel();

        $item_id = $this->request->getPost('item_id');

        $data = [
            'user_id' => $user_id,
            'category_id' => $this->request->getPost('category_id'),
            'item_name' => $this->request->getPost('item_name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        //Using insert and update method to prevent SQL injection.
        if ($item_id) {
            $menuModel->update($item_id, $data);
            session()->setFlashdata('success', 'Item updated successfully.');
        } else {
            $menuModel->insert($data);
            session()->setFlashdata('success', 'Item added successfully.');
        }

        return redirect()->to('/menuedit');
    }

    /**
     * Delete an item.
     *
     * @param int $item_id The item ID to delete.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deleteItem($item_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $menuModel = new \App\Models\MenuModel();

        $item = $menuModel->find($item_id);
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
        }

        $menuModel->delete($item_id);
        log_message('debug', 'Item deleted successfully.');
        session()->setFlashdata('success', 'Item deleted successfully.');

        return redirect()->to('/menuedit');
    }

    /**
     * Display the orders page with user's active and archived orders.
     */
    public function orders()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $orderModel = new \App\Models\OrderModel();
        $tableModel = new \App\Models\TablesModel();
        $orderItemModel = new \App\Models\OrderitemModel();
        $menuModel = new \App\Models\MenuModel();

        $data['activeOrders'] = $orderModel->where('user_id', $user_id)->where('order_status', 'active')->findAll();
        $data['archivedOrders'] = $orderModel->where('user_id', $user_id)->where('order_status !=', 'active')->orderBy('order_id', 'DESC')->findAll();

        foreach ($data['activeOrders'] as &$order) {
            $order['table'] = $tableModel->find($order['table_id']);
            $orderItems = $orderItemModel->where('order_id', $order['order_id'])->findAll();
            $order['first_item'] = $menuModel->find($orderItems[0]['menu_item_id'])['item_name'] ?? '';
        }

        foreach ($data['archivedOrders'] as &$order) {
            $order['table'] = $tableModel->find($order['table_id']);
        }

        return view('orders', $data);
    }

    /**
     * Display the order detail page for a specific order.
     *
     * @param int $order_id The order ID to view.
     */
    public function orderDetail($order_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderitemModel();
        $tableModel = new \App\Models\TablesModel();
        $menuModel = new \App\Models\MenuModel();

        $order = $orderModel->find($order_id);

        if (!$order || $order['user_id'] != $user_id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }

        $data['order'] = $order;
        $data['orderItems'] = $orderItemModel->where('order_id', $order_id)->findAll();
        $data['table'] = $tableModel->find($order['table_id']);

        foreach ($data['orderItems'] as &$orderItem) {
            $orderItem['menuItem'] = $menuModel->find($orderItem['menu_item_id']);
        }

        return view('orderdetail', $data);
    }

    /**
     * Update the status of an order.
     *
     * @param int $order_id The order ID to update.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateOrderStatus($order_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $orderModel = new \App\Models\OrderModel();

        $order = $orderModel->find($order_id);

        if (!$order || $order['user_id'] != $user_id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }

        $status = $this->request->getPost('status');

        if ($status == 'completed' || $status == 'cancelled') {
            $orderModel->update($order_id, ['order_status' => $status]);
            session()->setFlashdata('success', 'Order status updated successfully.');
        } else {
            session()->setFlashdata('error', 'Invalid order status.');
        }

        return redirect()->to('/orders/' . $order_id);
    }

    /**
     * Display the place order page for a specific table.
     *
     * @param int $table_id The table ID to place an order.
     */
    public function placeorder($table_id)
    {
        $tableModel = new \App\Models\TablesModel();
        $categoryModel = new \App\Models\CategoryModel();
        $menuModel = new \App\Models\MenuModel();

        $table = $tableModel->find($table_id);

        if (!$table) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Table not found');
        }

        $user_id = $table['user_id'];

        $data['table'] = $table;
        // Fetch all categories in category sequence.
        $data['categories'] = $categoryModel->where('user_id', $user_id)->orderBy('category_sort', 'asc')->findAll();

        // Fetch every active menu items in this catefory
        foreach ($data['categories'] as &$category) {
            $category['menu_items'] = $menuModel->where('category_id', $category['category_id'])
                ->where('is_active', 1)
                ->orderBy('price', 'asc')
                ->findAll();
        }

        // If a category has no active items, then it won't display.
        $data['categories'] = array_filter($data['categories'], function ($category) {
            return !empty($category['menu_items']);
        });

        return view('placeorder', $data);
    }

    /**
     * Create a new order for a specific table.
     *
     * @param int $table_id The table ID to create an order for.
     * @return \CodeIgniter\HTTP\Response
     */
    public function createOrder($table_id)
    {
        $tableModel = new \App\Models\TablesModel();
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderitemModel();
        $menuModel = new \App\Models\MenuModel();

        $table = $tableModel->find($table_id);

        if (!$table) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Table not found');
        }

        $customerEmail = $this->request->getJSON()->customer_email;
        $orderItems = $this->request->getJSON()->order_items;
        $totalPrice = $this->request->getJSON()->total_price;

        //Order will not create when no item selected (total price 0).
        if ($totalPrice <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No item'
            ]);
        }

        // Create order
        $sql = "INSERT INTO Orders (user_id, table_id, customer_email, total_price, order_status, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, [
            $table['user_id'],
            $table_id,
            $customerEmail,
            $totalPrice,
            'active',
            date('Y-m-d H:i:s')
        ]);

        $orderId = $this->db->insertID();

        // Create order items
        foreach ($orderItems as $item) {
            $menuItemId = $item->menu_item_id;
            $quantity = $item->quantity;
            $sql = "INSERT INTO Orderitem (order_id, menu_item_id, quantity) VALUES (?, ?, ?)";
            $this->db->query($sql, [$orderId, $menuItemId, $quantity]);
        }

        
        return $this->response->setJSON([
            'success' => true,
            'redirect' => base_url('/customer/order/' . $orderId)
        ]);
    }

    /**
     * Display the customer order detail page after successfully placing an order.
     * For security concern, I originally tried to use hash to encrypt order id to prevent direct url access,
     * but I encountered too many issues, so I changed to a easier way, and the code may look similar to a previous function.
     * But it intended to be different.
     * 
     * @param int $orderId The order ID to view.
     */
    public function customerOrderDetail($orderId)
    {
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderitemModel();
        $tableModel = new \App\Models\TablesModel();
        $menuModel = new \App\Models\MenuModel();

        $order = $orderModel->find($orderId);

        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }

        $data['order'] = $order;
        $data['orderItems'] = $orderItemModel->where('order_id', $orderId)->findAll();
        $data['table'] = $tableModel->find($order['table_id']);

        foreach ($data['orderItems'] as &$orderItem) {
            $orderItem['menuItem'] = $menuModel->find($orderItem['menu_item_id']);
        }

        return view('customerorderdetail', $data);
    }

    /**
     * Display the QR codes page with user's tables and their QR codes.
     */
    public function qrcodes()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $tableModel = new \App\Models\TablesModel();

        $tables = $tableModel->where('user_id', $user_id)->findAll();

        // Each QR code image saves the place order page with each table id.
        foreach ($tables as &$table) {
            $tableId = $table['table_id'];
            $placeorderLink = base_url('/placeorder/' . $tableId);

            $writer = new PngWriter();
            $qrCode = QrCode::create($placeorderLink)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            $result = $writer->write($qrCode);

            $table['qrcode_image'] = $result->getDataUri();
            $tableModel->update($tableId, ['qrcode_image' => $table['qrcode_image']]);
        }

        $data['tables'] = $tables;
        return view('qrcodes', $data);
    }

    /**
     * Add a new table and generate its QR code.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function addTable()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $user_id = session()->get('user_id');
        $tableModel = new \App\Models\TablesModel();

        $tableNumber = $this->request->getPost('table_number');

        $tableId = $tableModel->insert([
            'user_id' => $user_id,
            'table_number' => $tableNumber
        ]);

        $placeorderLink = base_url('/placeorder/' . $tableId);

        $writer = new PngWriter();
        $qrCode = QrCode::create($placeorderLink)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);

        $qrCodeImageData = $result->getDataUri();
        $tableModel->update($tableId, ['qrcode_image' => $qrCodeImageData]);

        return redirect()->to('/qrcodes');
    }

    /**
     * Delete a table.
     *
     * @param int $tableId The table ID to delete.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deleteTable($tableId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth');
        }

        $tableModel = new \App\Models\TablesModel();

        $table = $tableModel->find($tableId);
        if (!$table || $table['user_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Table not found');
        }

        $tableModel->delete($tableId);

        return redirect()->to('/qrcodes');
    }
}