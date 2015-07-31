<?php namespace App\Http\Controllers;

use App\Repositories\AdminRepository;
use DB;
use View;
use App\User;
use App\Admin;
use App\Category;
use App\Product;
use App\Order;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	/**
	 *	ADMIN ROUTE DEFINITIONS
	 */
	protected $pages = [
		'dashboard' => ['name' => 'Dashboard', 'partial' => 'dashboard'],
		'products' => ['name' => 'Products', 'partial' => 'products'],
		'categories' => ['name' => 'Categories', 'partial' => 'categories'],
		'ads' => ['name' => 'Ads', 'partial' => 'ads'],
		'orders' => ['name' => 'Orders', 'partial' => 'orders'],
		'transactions' => ['name' => 'Transactions', 'partial' => 'transactions'],
		'customers' => ['name' => 'Customers', 'partial' => 'customers'],
		'priceRules' => ['name' => 'Price Rules', 'partial' => 'price_rules'],
		'shipping' => ['name' => 'Shipping', 'partial' => 'shipping'],
		'preferences' => ['name' => 'Preferences', 'partial' => 'preferences'],
		'administration' => ['name' => 'Administration', 'partial' => 'administration'],
		'statistics' => ['name' => 'Statistics', 'partial' => 'statistics'],
	];

    protected $admin;

	public function __construct(AdminRepository $admin) {
//		View::share('pages', $this->pages);
        $this->admin = $admin;
       // $this->middleware('admin');
	}

    public function dashboard()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function products()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function categories()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function ads()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function orders()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function transactions()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function customers()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function priceRules()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function shipping()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function preferences()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function administration()
    {
        $this->admin->setShowPage(__FUNCTION__);
        $admins = $this->admin->all();
        return view('admin.main')
            ->with('admins', $admins);
    }

    public function statistics()
    {
        $this->admin->setShowPage(__FUNCTION__);
        return view('admin.main');
    }

    public function recieve($page = null)
    {
        if (page == null) {
            abort(404);
        }

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function recieves($page = null)
	{
		// reroute to dashboard if $page is null
		if($page == null) {
			return redirect('/admin/dashboard');
		}
		// check if page exists in $pages array
		if(array_key_exists($page, $this->pages)) {
			/**
			 * ADMIN ROUTES
			 */
            if ($page == 'administration') {
                $admins = Admin::all();
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('admins', $admins);
					
            } else if ($page == 'transactions') {
                $transactions = DB::table('transactions')->get();
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('transactions', $transactions);
					
            } else if ($page == 'shipping') {
                $shippers = DB::table('shippers')->get();
                $shipments = DB::table('shipments')->get();
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('shippers', $shippers)
                    ->with('shipments', $shipments);
            } else if ($page == 'price-rules') {
                $price_rules = DB::table('pricing_rules')->get();
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('price_rules', $price_rules);
					
            } else if ($page == 'customers') {
                $users = User::all();
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('customers', $users);
					
            } else if ($page == 'orders') {
                $orders = Order::all();
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('orders', $orders);
					
            } else if ($page == 'ads') {
                $products = Product::all()->where('reseller', 1);
                return view('admin.main')
                    ->with('currentPage', $page)
                    ->with('products', $products);
					
            } else if($page == 'products') {
				// retrieve all products, categories, sub-categories and post-sub-categories
				$products = Product::all()->where('reseller', 0);
				$_cats = Category::all();
				$_subcats = DB::table('sub_categories')->get();
				$_postsubcats = DB::table('post_sub_cats')->get();
				
				/*
				 * SHIFT EACH KEY OF EACH ARRAY BY ONE (ADD 1)
				 */
				
				$cats = [];
				$subcats = [];
				$postsubcats = [];
				
				foreach($_cats as $cat) {
					$cats[$cat->id] = $cat->name;
				}
				foreach($_subcats as $cat) {
					$subcats[$cat->id] = $cat->name;
				}
				foreach($_postsubcats as $cat) {
					$postsubcats[$cat->id] = $cat->name;
				}
				
				/* END SHIFT */
				
				return view('admin.main')
						->with('currentPage', $page)
						->with('products', $products)
						->with('cats', $cats)
						->with('subcats', $subcats)
						->with('postsubcats', $postsubcats);
						
			} else if($page == 'categories') {
				$cats = Category::all()->lists('name');
				$_subcats = DB::table('sub_categories')->get();
				$_postsubcats = DB::table('post_sub_cats')->get();
				
				$subcats = [];
				$postsubcats = [];
				
				foreach($_subcats as $cat) {
					$subcats[$cat->id] = $cat->name;
				}
				foreach($_postsubcats as $cat) {
					$postsubcats[$cat->id] = $cat->name;
				}
				
				
				return view('admin.main')
						->with('currentPage', $page)
						->with('cats', $cats)
						->with('subcats', $subcats)
						->with('postsubcats', $postsubcats);
			} else {
				return view('admin.main')->with('currentPage', $page);
			}
		} else {
			abort(404);
		}
	}
	
}
