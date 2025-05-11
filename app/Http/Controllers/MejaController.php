<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MejaController extends Controller
{

    public function nomorMeja(Request $request, $token, $nomor_meja)
    {
        $table = Table::where('nomor_meja', $nomor_meja)
            ->where('token', $token)
            ->first();

        if (!$table) {
            return abort(403, 'Token atau Nomor meja tidak valid.');
        }

        if (!session()->has('email') || !session()->has('name')) {

            session([
                'token' => request()->segment(2),
                'nomor_meja' => request()->segment(3),
            ]);

            return view('inputEmail')->with('showEmailModal', true);
        }

        session([
            'meja_id' => $table->id,
            'nomor_meja' => $table->nomor_meja,
            'url_meja' => url()->current(),
        ]);

        return redirect()->route('menu.meja.index');
    }

    public function saveEmailMeja(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        session([
            'email' => $request->email,
            'name' => $request->name
        ]);

        $token = $request->token;
        $nomor_meja = $request->nomor_meja;

        $table = Table::where('nomor_meja', $nomor_meja)
            ->where('token', $token)
            ->first();

        if (!$table) {
            return abort(403, 'Token atau Nomor meja tidak valid.');
        }

        session([
            'meja_id' => $table->id,
            'nomor_meja' => $table->nomor_meja,
            'url_meja' => url()->current(),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function index()
    {
        $categories = Category::all();
        $menuItems = Menu::with('category')->where('is_available', true)->orderBy('name')->get();

        return view('userTable', compact('categories', 'menuItems'));
    }

    public function store(Request $request)
    {
        $cartItems = json_decode($request->input('cart_items'), true);

        session()->forget(['email', 'name', 'meja_id', 'nomor_meja']);

        return response()->json([
            'message' => 'success',
            'cartItems' => $cartItems,
        ]);
    }
}
