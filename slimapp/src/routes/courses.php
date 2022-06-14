<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->get("/kitaplar", function (Request $request, Response $response) {
    $db = new Db();
    try {
        $db = $db->connect();
        $kitaplar = $db->query("Select k.Id,k.Ad,k.Yazar,k.Resim,k.Isbn,t.Ad as Tur,d.Ad as Durum,k.Tur as TurId
        from kitaplar k,turler t,durumlar d
        where k.Tur = t.Id and k.Durum = d.Id")->fetchAll(PDO::FETCH_OBJ);
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($kitaplar, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->get("/emanetlerim/{userId}", function (Request $request, Response $response) {
    $id = $request->getAttribute("userId");
    $db = new Db();
    try {
        $db = $db->connect();
        $kitaplar = $db->query("Select k.Id,k.Ad,k.Yazar,k.Resim,k.Isbn,t.Ad as Tur,d.Ad as Durum
        from emanetler e,turler t,durumlar d,kitaplar k 
        where k.Tur = t.Id and k.Durum = d.Id and k.Id = e.KitapId and e.KullaniciId = $id")->fetchAll(PDO::FETCH_OBJ);
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($kitaplar, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});

$app->get("/kitaplar/{id}", function (Request $request, Response $response) {
    $id = $request->getAttribute("id");
    $db = new Db();
    try {
        $db = $db->connect();
        $kitaplar = $db->query("Select * from kitaplar where Id=$id")->fetch(PDO::FETCH_OBJ);
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($kitaplar, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->post("/kitapekle", function (Request $request, Response $response) {
    $ad = $request->getParam("ad");
    $yazar = $request->getParam("yazar");
    $tur = $request->getParam("tur");
    $resim = $request->getParam("resim");
    $isbn = $request->getParam("isbn");
    $durum = 1;
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "INSERT INTO kitaplar(Ad,Yazar,Tur,Durum,Resim,Isbn)VALUES(:ad,:yazar,:tur,:durum,:resim,:isbn)";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("ad", $ad);
        $stmt1->bindParam("yazar", $yazar);
        $stmt1->bindParam("tur", $tur);
        $stmt1->bindParam("durum", $durum);
        $stmt1->bindParam("resim", $resim);
        $stmt1->bindParam("isbn", $isbn);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Kitap ekleme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->post("/kitapduzenle", function (Request $request, Response $response) {
    $id = $request->getParam("id");
    $ad = $request->getParam("ad");
    $yazar = $request->getParam("yazar");
    $tur = $request->getParam("tur");
    $resim = $request->getParam("resim");
    $isbn = $request->getParam("isbn");
    $durum = 1;
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "update kitaplar set Ad=:ad,Yazar=:yazar,Tur=:tur,Durum=:durum,Resim=:resim,Isbn=:isbn where Id=:id";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("id", $id);
        $stmt1->bindParam("ad", $ad);
        $stmt1->bindParam("yazar", $yazar);
        $stmt1->bindParam("tur", $tur);
        $stmt1->bindParam("durum", $durum);
        $stmt1->bindParam("resim", $resim);
        $stmt1->bindParam("isbn", $isbn);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Kitap güncelleme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->delete("/kitapsil/{id}", function (Request $request, Response $response) {
    $id = $request->getAttribute("id");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "delete from kitaplar where Id=:id";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("id", $id);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Kitap silme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->post("/kitapguncelle", function (Request $request, Response $response) {
    $id = $request->getParam("id");
    $ad = $request->getParam("ad");
    $yazar = $request->getParam("yazar");
    $tur = $request->getParam("tur");
    $durum = $request->getParam("durum");
    $resim = $request->getParam("resim");
    $isbn = $request->getParam("isbn");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "update kitaplar set Ad=:ad,Yazar=:yazar,Tur=:tur,Durum=:durum,Resim=:resim,Isbn=:isbn where Id=:id";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("id", $id);
        $stmt1->bindParam("ad", $ad);
        $stmt1->bindParam("yazar", $yazar);
        $stmt1->bindParam("tur", $tur);
        $stmt1->bindParam("durum", $durum);
        $stmt1->bindParam("resim", $resim);
        $stmt1->bindParam("isbn", $isbn);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Kitap güncelleme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});

$app->post("/emanetekle", function (Request $request, Response $response) {
    $kitapId = $request->getParam("kitapId");
    $kullaniciId = $request->getParam("kullaniciId");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "INSERT INTO emanetler(KitapId,KullaniciId)VALUES(:kitapId,:kullaniciId)";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("kitapId", $kitapId);
        $stmt1->bindParam("kullaniciId", $kullaniciId);
        $stmt1->execute();
        $sql2 = "update kitaplar set Durum=2 where Id=:kitapId";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("kitapId", $kitapId);
        $stmt2->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Emanet ekleme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->post("/emanetver", function (Request $request, Response $response) {
    $kitapId = $request->getParam("kitapId");
    $kullaniciId = $request->getParam("kullaniciId");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "delete from emanetler where KitapId=:kitapId and KullaniciId=:kullaniciId";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("kitapId", $kitapId);
        $stmt1->bindParam("kullaniciId", $kullaniciId);
        $stmt1->execute();
        $sql2 = "update kitaplar set Durum=1 where Id=:kitapId";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("kitapId", $kitapId);
        $stmt2->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Emanet verme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});

$app->get("/turler", function (Request $request, Response $response) {
    $db = new Db();
    try {
        $db = $db->connect();
        $turler = $db->query("Select Id as id,Ad as ad from turler")->fetchAll(PDO::FETCH_OBJ);
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($turler, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->post("/turekle", function (Request $request, Response $response) {
    $ad = $request->getParam("ad");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "INSERT INTO turler(Ad)VALUES(:ad)";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("ad", $ad);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Tür ekleme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->post("/turduzenle", function (Request $request, Response $response) {
    $id = $request->getParam("id");
    $ad = $request->getParam("ad");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "update turler set Ad=:ad where Id=:id";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("ad", $ad);
        $stmt1->bindParam("id", $id);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Tür düzenleme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});
$app->delete("/tursil/{id}", function (Request $request, Response $response) {
    $id = $request->getAttribute("id");
    $db = new Db();
    try {
        $db = $db->connect();
        $sql1 = "delete from turler where Id=:id";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("id", $id);
        $stmt1->execute();
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson("Tür silme başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson($th, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
});




$app->post('/kayit', function (Request $request, Response $response) {

    $username = $request->getParam("username");
    $name = $request->getParam("name");
    $passwordr = $request->getParam("password");
    $email = $request->getParam("email");

    $db = new Db();
    //$testToken = new Db();
    try {

        $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
        $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
        $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $passwordr);

        if (strlen(trim($username)) > 0 && strlen(trim($passwordr)) > 0 && strlen(trim($email)) > 0 && $email_check > 0 && $username_check > 0 && $password_check > 0) {
            $db = $db->connect();
            $userData = '';
            $sql = "SELECT Id FROM kullanicilar WHERE username=:username or email=:email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("username", $username);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            $mainCount = $stmt->rowCount();
            //$created=time();
            if ($mainCount == 0) {
                /*Inserting user values*/
                $sql1 = "INSERT INTO kullanicilar(username,password,email,name)VALUES(:username,:password,:email,:name)";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("username", $username);
                $password = hash('sha256', $passwordr);
                $stmt1->bindParam("password", $password);
                $stmt1->bindParam("email", $email);
                $stmt1->bindParam("name", $name);
                $stmt1->execute();
                //$testToken = $testToken->apiToken($email);
                // $user = internalUserDetails($email);
                // return $response
                // ->withStatus(200)
                // ->withHeader("Content-Type", 'application/json')
                // ->withJson($userData);

                return $response
                    ->withStatus(200)
                    ->withHeader("Content-Type", 'application/json')
                    //->withJson($user->token);
                    ->withJson("Kayıt Başarılı", null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            } else {
                return $response
                    ->withStatus(400)
                    ->withHeader("Content-Type", 'application/json')
                    ->withJson(array(
                        "error" => array(
                            "text"  => "Bu kullanıcı kayıtlı!"
                        )
                    ), null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            }
        } else {
            return $response
                ->withStatus(400)
                ->withHeader("Content-Type", 'application/json')
                ->withJson(array(
                    "error" => array(
                        "text"  => "Girdiğiniz bilgileri kontrol ediniz !"
                    )
                ), null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        }
    } catch (PDOException $e) {
        return $response->withJson(
            array(
                "error" => array(
                    "text"  => $e->getMessage(),
                    "code"  => $e->getCode()
                )
            ),
            null,
            JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
        );
    }
    $db = null;
});

$app->post('/giris', function (Request $request, Response $response) {

    $username = $request->getParam("username");
    $passwordr = $request->getParam("password");

    $db = new Db();
    try {

        $db = $db->connect();
        $userData = '';
        $statement = "SELECT * FROM kullanicilar WHERE (username=:username or email=:username) and password=:password";
        $prepare = $db->prepare($statement);
        $prepare->bindParam("username", $username);
        $password = hash('sha256', $passwordr);
        $prepare->bindParam("password", $password);

        $course = $prepare->execute();
        $userData = $prepare->fetch(PDO::FETCH_OBJ);

        if ($userData) {
            // $user = internalUserDetails($userData->username);
            return $response
                ->withStatus(200)
                ->withHeader("Content-Type", 'application/json')
                //->withJson($user->token);
                ->withJson($userData, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        } else {
            return $response
                ->withStatus(401)
                ->withHeader("Content-Type", 'application/json')
                ->withJson(array(
                    "error" => array(
                        "text"  => "Login işlemi sırasında bir problem oluştu."
                    )
                ), null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        }
    } catch (PDOException $e) {
        return $response->withJson(
            array(
                "error" => array(
                    "text"  => $e->getMessage(),
                    "code"  => $e->getCode()
                )
            ),
            null,
            JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
        );
    }
    $db = null;
});
function internalUserDetails($input)
{
    $db = new Db();
    $testToken = new Db();
    try {
        $db = $db->connect();
        $sql = "SELECT user_id, name, email, username FROM users WHERE username=:input or email=:input";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("input", $input);
        $stmt->execute();
        $usernameDetails = $stmt->fetch(PDO::FETCH_OBJ);
        $token = $testToken->apiToken($usernameDetails->user_id);
        //$token = $db->apiToken($usernameDetails->user_id);
        $usernameDetails->token = $token;
        $db = null;
        return $usernameDetails;
        //return $token;

    } catch (PDOException $e) {
        // return $response->withJson(
        //     array(
        //         "error" => array(
        //             "text"  => $e->getMessage(),
        //             "code"  => $e->getCode()
        //         )
        //     ),
        //     null,
        //     JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
        // );
    }
}
