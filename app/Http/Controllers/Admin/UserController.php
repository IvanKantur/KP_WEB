<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Список всех пользователей
    public function index()
    {
        $users = User::orderBy('id')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Форма создания нового пользователя
    public function create()
    {
        return view('admin.users.create');
    }

    // Сохранение нового пользователя
    public function store(Request $request)
    {
        // Валидация полей
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'boolean',
        ]);

        // Создаем пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()->route('admin.users')->with('success', 'Пользователь создан');
    }

    // Просмотр профиля пользователя и истории заказов
    public function show($id)
    {
        $user = User::findOrFail($id);
        // Ищем заказы по email или имени
        $orders = Order::where('customer_email', $user->email)
                      ->orWhere('customer_name', $user->name)
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('admin.users.show', compact('user', 'orders'));
    }

    // Форма редактирования пользователя
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Обновление пользователя
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'is_admin' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin'),
        ];

        // Если пароль заполнен — обновляем
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Пользователь обновлен');
    }

    // Удаление пользователя
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Не даем удалить самого себя
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Нельзя удалить самого себя');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'Пользователь удален');
    }

    // Назначить пользователя админом
    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = true;
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'Пользователь назначен администратором');
    }

    // Снять права админа
    public function removeAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // Не даем снять права админа с самого себя
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Нельзя снять права администратора с самого себя');
        }
        
        $user->is_admin = false;
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'Права администратора сняты');
    }
}