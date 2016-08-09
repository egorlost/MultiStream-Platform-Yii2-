<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script>
    ab.connect('ws://localhost:8080',
        function (session) {
            //подпишемся на новые комментарии. вторым параметром передаем функцию-обраточик события,
            //которая будет вызвана после получения комментария.
            session.subscribe('kittensCategory', onNewComment);
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'maxRetries': 100,
            'retryDelay': 5000}
    );
    function onNewComment(topic, data) {
        //topic - название канала, с которого пришло сообщение
        //в data находятся данные, переданные сервером.
        //в случае с комментариями это могут быть content и author.
        console.log('новый комментарий', data.id, data.msg);
    }
</script>
