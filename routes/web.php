<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\RolesPermissions\RolesController;
use App\Http\Controllers\Admin\RolesPermissions\PermissionsController;
use App\Http\Controllers\Admin\OderManagement\OderManagementController;
use App\Http\Controllers\Admin\ContentManagement\ContentManagementController;
use App\Http\Controllers\Admin\PaymentManagement\PaymentManagementController;
use App\Http\Controllers\Admin\ProductManagement\ProductManagementController;
use App\Http\Controllers\Admin\CustomerManagement\CustomerManagementController;
use App\Http\Controllers\Admin\AffiliateManagement\AffiliateManagementController;
use App\Http\Controllers\Admin\AnalyticsManagement\AnalyticsManagementController;
use App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController;
use App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController;
use App\Http\Controllers\Admin\PromotionsManagement\PromotionsManagementController;

// clients

use App\Http\Controllers\Client\Categories\CategoriesController;
use App\Http\Controllers\Client\Help\HelpController;
use App\Http\Controllers\Client\Product\ProductController;
use App\Http\Controllers\Client\Checkout\CheckoutController;
use App\Http\Controllers\Client\Custom\CustomOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $categories = Category::all();
    $subCategories = SubCategory::all();
    $subsubCategories = SubSubCategory::all();
    return view('index', compact('categories', 'subCategories', 'subsubCategories'));
});

Auth::routes();

Route::get('/client/index', [App\Http\Controllers\HomeController::class, 'client_index'])->name('client_index');


    /**
     * Categories
     */

    Route::group(['prefix' => 'client_categories'], function() {
        Route::get('/client/categories/categories/{id}', [App\Http\Controllers\Client\Categories\CategoriesController::class, 'categories'])->name('client.categories');
        Route::get('/client/categories/subcategories/{id}', [App\Http\Controllers\Client\Categories\CategoriesController::class, 'subcategories'])->name('client.subcategories');
        Route::get('/client/categories/subsububcategories/{id}', [App\Http\Controllers\Client\Categories\CategoriesController::class, 'subsubcategories'])->name('client.subsubcategories');
    });

    Route::group(['prefix' => 'client_help'], function() {
        Route::get('/client/help/', [App\Http\Controllers\Client\Help\HelpController::class, 'client_help'])-> name('client.help');
        Route::get('/client/help/search', [App\Http\Controllers\Client\Help\HelpController::class, 'inquiry_search'])-> name('client.inquiry');
        Route::post('/client/help/help/', [App\Http\Controllers\Client\Help\HelpController::class, 'store_inquiry'])-> name('send.inquiry');
    });

    Route::group(['prefix' => 'custom'], function() {
        Route::get('/client/custom/customorder', [App\Http\Controllers\Client\Custom\CustomOrderController::class, 'customorder'])-> name('custom.order');
        Route::post('/client/custom/customorder/store', [App\Http\Controllers\Client\Custom\CustomOrderController::class, 'placecustomorder'])-> name('place.custom.order');
    });

    Route::group(['prefix' => 'product', 'middleware' => 'web'], function () {
        Route::post('/add-to-cart-or-wishlist', [App\Http\Controllers\Client\Product\ProductController::class,'addToCartOrWishlist'])->name('add.cart.or.add.wishlist');
        Route::get('/client/product/search/', [App\Http\Controllers\Client\Product\ProductController::class, 'search_for_product'])->name('search.for.product');
        Route::get('/client/product/searchautocomplete/', [App\Http\Controllers\Client\Product\ProductController::class, 'search_autocomplete'])->name('search.autocomplete');
    
        Route::get('/client/product/product/{id}', [App\Http\Controllers\Client\Product\ProductController::class, 'view_product'])->name('view.product');
        Route::get('/client/product/cart/view', [App\Http\Controllers\Client\Product\ProductController::class, 'cart'])->name('cart.product');
        Route::get('/client/product/remove-from-cart/{id}', [App\Http\Controllers\Client\Product\ProductController::class, 'removeFromCart'])->name('remove.from.cart');
    
        Route::get('/client/product/wish/view/', [App\Http\Controllers\Client\Product\ProductController::class, 'wishlist'])->name('wish.product');
        Route::get('/client/product/remove-from-wish/{id}', [App\Http\Controllers\Client\Product\ProductController::class, 'removeFromWish'])->name('remove.from.wish');
    });
    
    Route::group(['prefix' => 'product', 'middleware' => 'web'], function () {
        Route::get('/client/checkout/checkout/', [App\Http\Controllers\Client\Checkout\CheckoutController::class, 'checkout'])->name('check.out');
        Route::post('/client/checkout/checkout/details', [App\Http\Controllers\Client\Checkout\CheckoutController::class, 'checkout_details'])->name('checkout.details');
    });
    

    /**
     * User Routes
     */
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users.index');
        Route::get('/search', [App\Http\Controllers\Admin\UsersController::class, 'searchusers'])->name('search.users');
        Route::get('/create', [App\Http\Controllers\Admin\UsersController::class, 'create'])->name('users.create');
        Route::post('/create', [App\Http\Controllers\Admin\UsersController::class, 'store'])->name('users.store');
        Route::get('/{user}/show', [App\Http\Controllers\Admin\UsersController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('users.edit');
        Route::patch('/{user}/update', [App\Http\Controllers\Admin\UsersController::class, 'update'])->name('users.update');
        Route::delete('/{user}/delete', [App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('users.destroy');
    });

    /**
     * User Roles
     */
    Route::group(['prefix' => 'roles'], function() {
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
 
    /**
     * Dasbhboard Overview
     */
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('/admin/dashboard/overview', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'overview'])->name('overview');
        Route::get('/admin/dashboard/bargraph', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'getMonthlySalesData'])->name('monthly.sales');
        Route::get('/admin/dashboard/linegraph', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'getDailySalesData'])->name('daily.sales');
    });

    /**
     * Order Management
     */
    Route::group(['prefix' => 'orders'], function() {
        Route::get('/admin/odermanagent/proccessing', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'proccessing'])->name('proccessing');
        Route::get('/admin/odermanagent/custom', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'custom'])->name('custom');
        Route::get('/admin/odermanagent/search', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'searchOrder'])->name('search.orders');
       
        Route::get('/admin/odermanagent/returns', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'returns'])->name('returns');
        Route::get('/client/returns/returns', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'client_returns'])->name('client.returns');
        Route::get('/admin/odermanagent/search/returns', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'searchReturn'])->name('search.returns');
        Route::post('/admin/odermanagent/returns/store', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'return_store'])->name('returns.store');
        Route::get('/admin/odermanagent/returnsresources/show/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'return_show'])->name('show.return');
        Route::patch('/admin/odermanagent/update/return/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'updateReturnStatus'])->name('update.return.status');
        Route::delete('/admin/odermanagent/delete/return/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'return_delete'])->name('delete.return');


        Route::get('/admin/odermanagent/orderresources/show/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'order_show'])->name('show.order');
        Route::patch('/admin/odermanagent/update/order/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'updateOrderStatus'])->name('update.order.status');
        Route::delete('/admin/odermanagent/delete/order/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'order_delete'])->name('delete.order');
   
        Route::get('/admin/odermanagent/orderresources/customshow/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'custom_show'])->name('show.custom.order');
        Route::patch('/admin/odermanagent/update/customorder/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'updateCustomStatus'])->name('update.custom.status');
        Route::delete('/admin/odermanagent/delete/customorder/{id}', [App\Http\Controllers\Admin\OderManagement\OderManagementController::class, 'custom_delete'])->name('delete.custom.order');

    });
    /**
     * Product Management
     */
    Route::group(['prefix' => 'products'], function() {
        /**
         * Catalog resources
         */
        Route::get('/admin/productmanagement/catalog', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'products'])->name('products');
        Route::get('/admin/productmanagement/catalogresources/search', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'searchproduct'])->name('search.product');
        Route::get('/admin/productmanagement/catalogresources/create', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'create_product'])->name('create.product');
        Route::post('/admin/productmanagement/catalogresources', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'store_product'])->name('store.product');
        Route::get('/admin/productmanagement/catalogresources/edit/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'edit_product'])->name('edit.product');
        Route::put('/admin/productmanagement/catalogresources/update/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'update_product'])->name('update.product');
        Route::get('/admin/productmanagement/catalogresources/show/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'show_product'])->name('show.product');
        Route::delete('/admin/productmanagement/catalogresources/delete/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'delete_product'])->name('delete.product');
        
        /*
         * Category resources
         */
        Route::get('/admin/productmanagement/categories', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'categories'])->name('categories');
        Route::get('/admin/productmanagement/categories/search', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'searchCategories'])->name('search.categories');
        Route::get('/admin/productmanagement/categoriesresources/create', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'create_categories'])->name('create.categories');
        Route::post('/admin/productmanagement/categoriesresources', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'store_categories'])->name('store.categories');
        Route::get('/admin/productmanagement/categoriesresources/edit/{id}/', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'edit_categories'])->name('edit.categories');
        Route::put('/admin/productmanagement/categoriesresources/update/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'update_categories'])->name('update.categories');
        Route::get('/admin/productmanagement/categoriesresources/show/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'show_categories'])->name('show.categories');
        Route::delete('/admin/productmanagement/categoriesresources/delete/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'delete_categories'])->name('delete.categories');
        /**
         * SubCategory resources
         */
        Route::get('/admin/productmanagement/subcategoriesresources/index', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'subcategories'])->name('subcategories');
        Route::get('/admin/productmanagement/subcategories/search', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'searchsubCategories'])->name('search.subcategories');
        Route::get('/admin/productmanagement/subcategoriesresources/create', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'create_subcategories'])->name('create.subcategories');
        Route::post('/admin/productmanagement/subcategoriesresources/', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'store_subcategories'])->name('store.subcategories');
        Route::get('/admin/productmanagement/subcategoriesresources/edit/{id}/', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'edit_subcategories'])->name('edit.subcategories');
        Route::put('/admin/productmanagement/subcategoriesresources/update/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'update_subcategories'])->name('update.subcategories');
        Route::get('/admin/productmanagement/subcategoriesresources/show/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'show_subcategories'])->name('show.subcategories');
        Route::delete('/admin/productmanagement/subcategoriesresources/delete/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'delete_subcategories'])->name('delete.subcategories');
        
        /**
         * Sub-SubCategory resources
         */
        Route::get('/admin/productmanagement/subsubcategoriesresources/index', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'subsubcategories'])->name('subsubcategories');
        Route::get('/admin/productmanagement/subsubcategories/search', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'searchsubsubCategories'])->name('search.subsubcategories');
        Route::get('/admin/productmanagement/subsubcategoriesresources/create', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'create_subsubcategories'])->name('create.subsubcategories');
        Route::post('/admin/productmanagement/subsubcategoriesresources/', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'store_subsubcategories'])->name('store.subsubcategories');
        Route::get('/admin/productmanagement/subsubcategoriesresources/edit/{id}/', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'edit_subsubcategories'])->name('edit.subsubcategories');
        Route::put('/admin/productmanagement/subsubcategoriesresources/update/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'update_subsubcategories'])->name('update.subsubcategories');
        Route::get('/admin/productmanagement/subsubcategoriesresources/show/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'show_subsubcategories'])->name('show.subsubcategories');
        Route::delete('/admin/productmanagement/subsubcategoriesresources/delete/{id}', [App\Http\Controllers\Admin\ProductManagement\ProductManagementController::class, 'delete_subsubcategories'])->name('delete.subsubcategories');
        
    });

   
    /**
     * Inventory Management
     */
    Route::group(['prefix' => 'inventory'], function() {
        /**
         * Levels resources
         */
        Route::get('/admin/inventorymanagement/levels', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'levels'])->name('levels');
        Route::get('/admin/inventorymanagement/levels/search', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'searchlevel'])->name('search.level');
        Route::get('/admin/inventorymanagement/levels/reorder', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'reorder'])->name('reorder.products');
        Route::get('/admin/inventorymanagement/levels/outofstock', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'outOfStock'])->name('outofstock.products');
        Route::get('/admin/inventorymanagement/levels/instocked', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'inStock'])->name('instock.products');
        
        
        
        /**
         * Supplier resources
         */
        Route::get('/admin/inventorymanagement/supplier', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'suppliers'])->name('suppliers');
        Route::get('/admin/inventorymanagement/supplierresources/search', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'searchsupplier'])->name('search.suppliers');
        Route::get('/admin/inventorymanagement/supplierresources/create', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'create_suppliers'])->name('create.suppliers');
        Route::post('/admin/inventorymanagement/supplierresources/', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'store_suppliers'])->name('store.suppliers');
        Route::get('/admin/inventorymanagement/supplierresources/edit/{id}/', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'edit_suppliers'])->name('edit.suppliers');
        Route::put('/admin/inventorymanagement/supplierresources/update/{id}', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'update_suppliers'])->name('update.suppliers');
        Route::get('/admin/inventorymanagement/supplierresources/show/{id}', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'show_suppliers'])->name('show.suppliers');
        Route::delete('/admin/inventorymanagement/supplierresources/delete/{id}', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'delete_suppliers'])->name('delete.suppliers');
        /**
         * Warehouse resources
         */
        Route::get('/admin/inventorymanagement/faq', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'warehouse'])->name('warehouse');
        Route::get('/admin/inventorymanagement/warehouseresources/search', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'searchwarehouse'])->name('search.warehouse');
        Route::get('/admin/inventorymanagement/warehouseresources/create', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'create_warehouse'])->name('create.warehouse');
        Route::post('/admin/inventorymanagement/warehouseresources/', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'store_warehouse'])->name('store.warehouse');
        Route::get('/admin/inventorymanagement/warehouseresources/edit/{id}/', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'edit_warehouse'])->name('edit.warehouse');
        Route::put('/admin/inventorymanagement/warehouseresources/update/{id}', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'update_warehouse'])->name('update.warehouse');
        Route::get('/admin/inventorymanagement/warehouseresources/show/{id}', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'show_warehouse'])->name('show.warehouse');
        Route::delete('/admin/inventorymanagement/warehouseresources/delete/{id}', [App\Http\Controllers\Admin\InventoryManagement\InventoryManagementController::class, 'delete_warehouse'])->name('delete.warehouse');
    });


    /**
     * Payment Management
     */
    Route::group(['prefix' => 'payment'], function() {
        Route::get('/admin/paymentmanagement/payment_get', [App\Http\Controllers\Admin\PaymentManagement\PaymentManagementController::class, 'payment_get'])->name('payment_get');
        Route::get('/admin/paymentmanagement/payment_pro', [App\Http\Controllers\Admin\PaymentManagement\PaymentManagementController::class, 'payment_pro'])->name('payment_pro');
    });



    /**
     * Analytics Management
     */
    Route::group(['prefix' => 'analytics'], function() {
        Route::get('/admin/analyticsmanagement/sales', [App\Http\Controllers\Admin\AnalyticsManagement\AnalyticsManagementController::class, 'sales'])->name('sales');
        Route::get('/admin/analyticsmanagement/customsales', [App\Http\Controllers\Admin\AnalyticsManagement\AnalyticsManagementController::class, 'customsales'])->name('custom.sales');
    });


    /**
     * Reports
     */
    Route::group(['prefix' => 'reports'], function() {
        // Sales reports
        Route::get('/reports/sales', [App\Http\Controllers\Admin\AnalyticsManagement\AnalyticsManagementController::class, 'salesreport'])->name('sales.report');
        Route::get('/reports/customs', [App\Http\Controllers\Admin\AnalyticsManagement\AnalyticsManagementController::class, 'customsalesreport'])->name('custom.sales.report');

    });

    /**
     * Content Management
     */
    Route::group(['prefix' => 'content'], function() {
    //    Banners
        Route::get('/admin/contentmanagement/banners', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'banners'])->name('banners');
        Route::get('/admin/contentmanagement/contentresources/search', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'searchbanners'])->name('search.banners');
        Route::get('/admin/contentmanagement/contentresources/create', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'create_banners'])->name('create.banners');
        Route::post('/admin/contentmanagement/contentresources', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'store_banners'])->name('store.banners');
        Route::get('/admin/contentmanagement/contentresources/edit/{id}/', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'edit_banners'])->name('edit.banners');
        Route::put('/admin/contentmanagement/contentresources/update/{id}', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'update_banners'])->name('update.banners');
        Route::get('/admin/contentmanagement/contentresources/show/{id}', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'show_banners'])->name('show.banners');
        Route::delete('/admin/contentmanagement/contentresources/delete/{id}', [App\Http\Controllers\Admin\ContentManagement\ContentManagementController::class, 'delete_banners'])->name('delete.banners');
    });

    /**
     * Customer Support Management
     */
    Route::group(['prefix' => 'support'], function() {
        Route::get('/admin/customersupportmanagement/help', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'help'])->name('help');
        Route::get('/admin/customersupportmanagement/index', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'index_faq'])->name('index.faq');
        Route::get('/admin/customersupportmanagement/searchfaq', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'searchfaq'])->name('search.faq');
        Route::get('/admin/customersupportmanagement/searchinquiry', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'searchinquiry'])->name('search.inquiry');
        Route::get('/admin/customersupportmanagement/create', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'create_faq'])->name('create.faq');
        Route::post('/admin/customersupportmanagement/', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'store_faq'])->name('store.faq');
        Route::get('/admin/customersupportmanagement/edit/{id}/', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'edit_faq'])->name('edit.faq');
        Route::put('/admin/customersupportmanagement/update/{id}', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'update_faq'])->name('update.faq');
        Route::get('/admin/customersupportmanagement/showfaq/{id}', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'show_faq'])->name('show.faq');
        Route::get('/admin/customersupportmanagement/showinquiry/{id}', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'show_inquiry'])->name('show.inquiry');
        Route::delete('/admin/customersupportmanagement/delete/{id}', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'delete_faq'])->name('delete.faq');
        Route::delete('/admin/customersupportmanagement/deleteinquiry/{id}', [App\Http\Controllers\Admin\CustomerSupportManagement\CustomerSupportController::class, 'delete_inquiry'])->name('delete.inquiry');
    });

   

