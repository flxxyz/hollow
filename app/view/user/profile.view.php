<?php
view('layout/header', [
    'title'       => $title,
    'keyword'     => 'login',
    'description' => 'login',
]);
?>
<div class="container">
    <div>
        <p><a href="/user/logout">退出帐号</a></p>
    </div>
    <table class="table is-hoverable">
        <thead>
            <tr>
                <th>ID</th>
                <th>from</th>
                <th>to</th>
                <th style="width:20%">内容</th>
                <th>QQ</th>
                <!--th>手机</th-->
                <th>IP</th>
                <th>特效</th>
                <th>背景</th>
                <th>匿名</th>
                <th>隐藏</th>
                <th>hash</th>
                <th>创建时间</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>from</th>
                <th>to</th>
                <th>内容</th>
                <th>QQ</th>
                <!--th>手机</th-->
                <th>IP</th>
                <th>特效</th>
                <th>背景</th>
                <th>匿名</th>
                <th>隐藏</th>
                <th>hash</th>
                <th>创建时间</th>
            </tr>
        </tfoot>
        <tbody>
        <?php foreach ($explains as $id => $item): ?>
            <tr>
                <td><?php _e($id) ?></td>
                <td><?php
                    _e((mb_strlen($item['user_from']) > 6) ? msubstr($item['user_from'], 0, 6):$item['user_from'])
                    ?></td>
                <td><?php
                    _e((mb_strlen($item['user_to']) > 6) ? msubstr($item['user_to'], 0 , 6):$item['user_to'])
                    ?></td>
                <td><p><?php
                        _e((mb_strlen($item['content']) > 12) ? msubstr($item['content'], 0, 12):$item['content'])
                        ?></p></td>
                <td><?php _e($item['qq'] ?? '') ?></td>
                <td><?php _e($item['ip']) ?></td>
                <td><?php _e($item['effect']) ?></td>
                <td><?php _e($item['bg']) ?></td>
                <td><?php _e($item['anonymous'] ? '启用' : '关闭') ?></td>
                <td><?php _e($item['hide'] ? '启用' : '关闭') ?></td>
                <td><a href="/s/<?php _e($item['hash']) ?>" target="_blank"><?php _e($item['hash']) ?></a></td>
                <td><?php _e(format_date($item['created_time'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>