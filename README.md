# CSRF (Cross-Site Request Forgery) Nedir?
![image](https://github.com/user-attachments/assets/f1e9fd76-52af-4beb-b335-d94e76b062f8)

**CSRF (Siteler Arası İstek Sahteciliği)**, kötü niyetli bir kullanıcının, başka bir kullanıcının oturumu üzerinden işlem yapmasına olanak tanıyan bir saldırı türüdür. Özellikle kimlik doğrulaması gerektiren web uygulamalarında ciddi riskler oluşturur.

## CSRF Nasıl Çalışır?

1. **Oturum Çerezleri Üzerinden:** Kullanıcı, siteye giriş yaptığında tarayıcıda oturum çerezi oluşturulur.
2. **Kötü Niyetli İstek Gönderme:** Kötü niyetli bir kullanıcı, bu oturum çerezlerini kullanarak hedef sitede habersiz işlem yapabilir.
3. **Kimlik Doğrulama Eksikliği:** Eğer bir site, işlemlerinde CSRF koruması kullanmıyorsa, isteklerin yetkili kullanıcı tarafından mı yoksa bir saldırgan tarafından mı yapıldığını ayırt edemez.

## CSRF Saldırısına Karşı Korunma

Projelerde CSRF'yi önlemek için en yaygın yöntem, **CSRF token** kullanımıdır. CSRF token, her form gönderiminde benzersiz bir anahtar olarak çalışır ve kullanıcının kimliğini doğrular.

### CSRF Token Nasıl Kullanılır?

Aşağıdaki örnek kodlar CSRF token kullanımını gösterir:

```php
<?php
session_start();

// 1. CSRF Token oluşturma
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. CSRF Token doğrulama
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "CSRF token doğrulandı!";
    } else {
        die("Geçersiz CSRF token!");
    }
}
?>
```

Formunuzda `csrf_token` gizli alanında bulunmalıdır:

```html
<form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <!-- Diğer form alanları -->
    <button type="submit">Gönder</button>
</form>
```

## CSRF Token Nedir?

- **CSRF Token**: Kullanıcıya özel olarak sunucu tarafından üretilen benzersiz bir kimlik doğrulama anahtarıdır.
- **Kullanım Amacı**: Her form gönderiminde token kontrol edilerek, isteklerin geçerliliği doğrulanır ve yalnızca gerçek kullanıcılar işlem yapabilir.

## GitHub Projelerinde CSRF Koruması

GitHub projelerinde CSRF korumasını entegre etmek, kullanıcı verilerini ve işlemlerini daha güvenli hale getirir. Özellikle oturum açmış kullanıcıların işlemlerini korumak için CSRF token’larının kullanılması önerilir.

## Kaynaklar

- [OWASP CSRF Koruması](https://owasp.org/www-community/attacks/csrf)
- [GitHub Güvenlik Kılavuzu](https://docs.github.com/en/github/authenticating-to-github)
- [Görsel](https://www.google.com/url?sa=i&url=https%3A%2F%2Fphppot.com%2Fphp%2Fcross-site-request-forgery-anti-csrf-protection-in-php%2F&psig=AOvVaw2F2h0orIwEQAZIt5nXSCI0&ust=1731488281402000&source=images&cd=vfe&opi=89978449&ved=0CBcQjhxqFwoTCPjgkdW21okDFQAAAAAdAAAAABAc)
```
