@extends('main')

@section('title', 'Корзина')

@section('content')
<h2>Корзина</h2>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

@if(empty($products))
    <div class="cart-empty">
        <div class="cart-empty-icon">🛒</div>
        <p>Ваша корзина пуста</p>
        <p>Добавьте товары из каталога</p>
        <a href="{{ route('catalog') }}" class="cart-empty-btn">Перейти в каталог</a>
    </div>
@else
    <div class="cart-container">
        <!-- Список товаров -->
        <div class="cart-items">
            @foreach($products as $product)
            <div class="cart-item" data-product-id="{{ $product['id'] }}">
                <div class="cart-item-image">
                    <div class="image-placeholder">📦</div>
                </div>
                <div class="cart-item-details">
                    <h3 class="cart-item-title">{{ $product['name'] }}</h3>
                    <div class="cart-item-price">{{ number_format($product['price'], 0, ',', ' ') }} ₽</div>
                </div>
                <div class="cart-item-quantity">
                    <label>Количество</label>
                    <div class="quantity-control">
                        <button class="qty-btn minus" data-id="{{ $product['id'] }}">−</button>
                        <input type="number" class="cart-qty-input" data-id="{{ $product['id'] }}" value="{{ $product['quantity'] }}" min="1" readonly>
                        <button class="qty-btn plus" data-id="{{ $product['id'] }}">+</button>
                    </div>
                </div>
                <div class="cart-item-subtotal">
                    <div class="subtotal-label">Сумма</div>
                    <div class="subtotal-value subtotal-{{ $product['id'] }}">{{ number_format($product['subtotal'], 0, ',', ' ') }} ₽</div>
                </div>
                <div class="cart-item-remove">
                    <button class="remove-item" data-id="{{ $product['id'] }}" title="Удалить">✕</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Итого и оформление -->
        <div class="cart-summary">
            <div class="summary-title">Итого к оплате</div>
            <div class="summary-total">
                <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-actions-row">
                <button id="clear-cart" class="btn-secondary">
                    🗑️ Очистить
                </button>
                <a href="{{ route('cart.checkout') }}" class="btn-primary">
                    Оформить заказ →
                </a>
            </div>
        </div>
    </div>
@endif

<!-- Модальное окно подтверждения -->
<div id="confirm-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-icon">⚠️</span>
            <h3>Подтверждение</h3>
        </div>
        <div class="modal-body">
            <p id="modal-message">Вы уверены?</p>
        </div>
        <div class="modal-footer">
            <button id="modal-cancel" class="btn-modal btn-modal-cancel">Отмена</button>
            <button id="modal-confirm" class="btn-modal btn-modal-confirm">Да, подтверждаю</button>
        </div>
    </div>
</div>

<style>
/* Корзина - современный стиль */
.cart-container {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.cart-items {
    flex: 2;
    min-width: 300px;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: var(--white);
    border: 1px solid var(--gray-border);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.cart-item:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.cart-item-image {
    width: 80px;
    height: 80px;
    background: var(--gray-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-placeholder {
    font-size: 32px;
}

.cart-item-details {
    flex: 2;
}

.cart-item-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 8px 0;
}

.cart-item-price {
    color: var(--blue-dark);
    font-weight: 500;
}

.cart-item-quantity {
    min-width: 120px;
    text-align: center;
}

.cart-item-quantity label {
    font-size: 12px;
    color: var(--gray-text);
    display: block;
    margin-bottom: 8px;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
}

.qty-btn {
    width: 32px;
    height: 32px;
    background: var(--gray-light);
    border: 1px solid var(--gray-border);
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: all 0.2s;
}

.qty-btn:hover {
    background: var(--blue-dark);
    color: var(--white);
    border-color: var(--blue-dark);
}

.cart-qty-input {
    width: 50px;
    text-align: center;
    border: 1px solid var(--gray-border);
    border-radius: 8px;
    padding: 6px;
    font-size: 14px;
    background: var(--white);
}

.cart-item-subtotal {
    min-width: 100px;
    text-align: center;
}

.subtotal-label {
    font-size: 12px;
    color: var(--gray-text);
    margin-bottom: 8px;
}

.subtotal-value {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--blue-dark);
}

.cart-item-remove {
    min-width: 40px;
}

.remove-item {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: var(--gray-text);
    transition: color 0.2s;
}

.remove-item:hover {
    color: #dc3545;
}

/* Блок итого */
.cart-summary {
    flex: 1;
    min-width: 280px;
    background: var(--gray-light);
    border-radius: 16px;
    padding: 25px;
    position: sticky;
    top: 100px;
    height: fit-content;
}

.summary-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 20px;
}

.summary-total {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin: 15px 0;
}

.summary-divider {
    height: 1px;
    background: var(--gray-border);
    margin: 20px 0;
}

.summary-actions-row {
    display: flex;
    gap: 12px;
    margin-top: 10px;
}

.btn-secondary {
    flex: 1;
    background: transparent;
    border: 2px solid #6c757d;
    color: #6c757d;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.btn-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-primary {
    flex: 1;
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-light) 100%);
    border: none;
    color: white;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 180, 216, 0.3);
}

/* Уведомления */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 4px solid #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 4px solid #dc3545;
}

/* Пустая корзина */
.cart-empty {
    text-align: center;
    padding: 60px 20px;
    background: var(--gray-light);
    border-radius: 20px;
}

.cart-empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.cart-empty p {
    margin: 10px 0;
    color: var(--gray-text);
}

.cart-empty a {
    color: var(--blue-dark);
    text-decoration: none;
}

/* Модальное окно */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal.show {
    display: flex;
}

.modal-content {
    background: var(--white);
    border-radius: 20px;
    width: 90%;
    max-width: 400px;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header {
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-light) 100%);
    padding: 20px;
    text-align: center;
}

.modal-icon {
    font-size: 48px;
    display: block;
    margin-bottom: 10px;
}

.modal-header h3 {
    color: var(--white);
    margin: 0;
    font-size: 1.3rem;
}

.modal-body {
    padding: 30px 20px;
    text-align: center;
}

.modal-body p {
    color: var(--gray-dark);
    font-size: 1rem;
    line-height: 1.5;
}

.modal-footer {
    display: flex;
    gap: 12px;
    padding: 20px;
    border-top: 1px solid var(--gray-border);
    justify-content: center;
}

.btn-modal {
    padding: 10px 24px;
    border: none;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-cancel {
    background: var(--gray-light);
    color: var(--gray-dark);
    border: 1px solid var(--gray-border);
}

.btn-modal-cancel:hover {
    background: var(--gray-border);
}

.btn-modal-confirm {
    background: var(--blue-dark);
    color: var(--white);
}

.btn-modal-confirm:hover {
    background: #dc3545;
}

/* Адаптация */
@media (max-width: 768px) {
    .cart-item {
        flex-wrap: wrap;
    }
    .cart-item-quantity {
        order: 3;
    }
    .cart-item-subtotal {
        order: 4;
    }
    .cart-item-remove {
        order: 5;
        margin-left: auto;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let modalCallback = null;

    function showConfirm(message, onConfirm) {
        const modal = document.getElementById('confirm-modal');
        const messageEl = document.getElementById('modal-message');
        const confirmBtn = document.getElementById('modal-confirm');
        const cancelBtn = document.getElementById('modal-cancel');
        
        messageEl.textContent = message;
        modal.classList.add('show');
        
        modalCallback = onConfirm;
        
        const newConfirmBtn = confirmBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        
        newConfirmBtn.addEventListener('click', function() {
            modal.classList.remove('show');
            if (modalCallback) modalCallback();
            modalCallback = null;
        });
        
        newCancelBtn.addEventListener('click', function() {
            modal.classList.remove('show');
            modalCallback = null;
        });
        
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                modalCallback = null;
            }
        });
    }

    window.confirm = function(message, callback) {
        return new Promise((resolve) => {
            showConfirm(message, () => resolve(true));
        });
    };

    function updateCart() {
        let items = [];
        document.querySelectorAll('.cart-qty-input').forEach(input => {
            let productId = input.dataset.id;
            let quantity = parseInt(input.value);
            if (quantity > 0) {
                items.push({
                    id: productId,
                    quantity: quantity
                });
            }
        });

        fetch('{{ route("cart.update-all") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.items.forEach(item => {
                    let subtotalElem = document.querySelector('.subtotal-' + item.id);
                    if (subtotalElem) {
                        subtotalElem.innerText = item.subtotal_formatted;
                    }
                });
                let totalElem = document.querySelector('.summary-total span');
                if (totalElem) {
                    totalElem.innerText = data.total_formatted;
                }
            }
        });
    }

    // Кнопки + и -
    document.querySelectorAll('.minus').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            let input = document.querySelector(`.cart-qty-input[data-id="${id}"]`);
            let val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                updateCart();
            }
        });
    });

    document.querySelectorAll('.plus').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            let input = document.querySelector(`.cart-qty-input[data-id="${id}"]`);
            let val = parseInt(input.value);
            input.value = val + 1;
            updateCart();
        });
    });

    // Удаление товара
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            let productId = this.dataset.id;
            window.confirm('Удалить товар из корзины?').then(confirmed => {
                if (confirmed) {
                    fetch('{{ route("cart.remove-all") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let row = document.querySelector(`.cart-item[data-product-id="${productId}"]`);
                            if (row) row.remove();
                            let totalElem = document.querySelector('.summary-total span');
                            if (totalElem) totalElem.innerText = data.total_formatted;
                            if (data.cart_empty) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        });
    });

    // Очистка корзины
    let clearBtn = document.getElementById('clear-cart');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            window.confirm('Очистить корзину? Все товары будут удалены.').then(confirmed => {
                if (confirmed) {
                    fetch('{{ route("cart.clear-all") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
                }
            });
        });
    }
});
</script>
@endsection