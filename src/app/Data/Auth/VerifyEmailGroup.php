<?php

namespace App\Data\Auth;

enum VerifyEmailGroup: string
{
    case ShopUser = 'shop_user';
    case SellerUser = 'seller_user';
    case AdminUser = 'admin_user';
}
