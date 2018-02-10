<?php

use App\Controller\{
    IndexController, LoveController
};

$route->get('/', [IndexController::class, 'index']);
$route->get('/say', [LoveController::class, 'say']);

$route->group('/api', function () {
    $this->get('/say', function () {
        $data = [
            'code'  => 1,
            'message' => 'success',
            'data'    => [],
        ];
        return json($data);
    });
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