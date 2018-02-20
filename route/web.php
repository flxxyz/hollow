<?php

use App\Controller\{
    Controller, LoveController, ApiController, ImgController, LikeController
};

$route->group('/', function () {
    $this->get('/', [LoveController::class, 'index']);
    $this->get('/say', [LoveController::class, 'say']);
    $this->get('/s/?', [new LoveController, 'show']);
    $this->get('/pic/?', [new ImgController, 'qq']);
});

$route->group('/api', function () {
    $this->any('/say', [ApiController::class, 'say']);
    $this->post('/like/?/add', [LikeController::class, 'add']);
    $this->get('/like/?/get', [LikeController::class, 'get']);
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