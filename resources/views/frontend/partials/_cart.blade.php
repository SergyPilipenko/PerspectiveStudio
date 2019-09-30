<cart :app_cart="'{{ app('App\Models\Cart\CartInterface')->getCart() }}'" :checkout_link="'{{ route('frontend.checkout.index') }}'"></cart>
