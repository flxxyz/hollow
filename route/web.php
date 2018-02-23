<?php

use App\Controller\{
    LoveController, ApiController, ImgController, LikeController, UserController
};

$route->group('/', function () {
    $this->get('/', [LoveController::class, 'index']);
    $this->get('/say', [LoveController::class, 'say']);
    $this->get('/s/?', [LoveController::class, 'show']);
    $this->get('/pic/?', [ImgController::class, 'qq']);
});

$route->group('/user', function () {
    $this->get('/', function () {
        redirect('/user/login');
    });
    $this->get('/login', [UserController::class, 'login']);
    $this->get('/logout', [UserController::class, 'logout']);
    $this->get('/profile', [UserController::class, 'profile']);
});

$route->group('/api', function () {
    $this->any('/say', [ApiController::class, 'say']);
    $this->post('/like/?/add', [LikeController::class, 'add']);
    $this->get('/like/?/get', [LikeController::class, 'get']);
    $this->any('/comment', [ApiController::class, 'comment']);
    $this->any('/login', [ApiController::class, 'login']);
});

$route->any('*', function () {
    $data = [
        'title'  => '运气，偶然，巧合',
        'result' => [
            '这一切都是命运石之门的安排！',
            'All this is destiny stone door arrangement!',
            '¡Todo esto es el arreglo de puerta de piedra del destino!',
            'すべてこれは運命の石のドアの配置です！',
            '이 모든 운명 돌 문 배열입니다!',
            'Все это судьба каменная дверь!',
            'All das ist Schicksal Stein Tür Anordnung!',
            'ทั้งหมดนี้เป็นประตูหินโชคชะตาจัด!',
            'Tất cả điều này là sự sắp xếp cửa đá số phận!',
            'Всичко това е съдбата каменна врата договореност!',
        ],
    ];
    view('all', $data, 404);
});