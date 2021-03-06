<?php $title = '活動篩選'; ?>

<?php include __DIR__ . '/1_parts/0_config.php'; ?>

<?php
$pageName = 'filter';

// 拿篩選內的項目，所有商品是0
$cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;

$sql = "SELECT * FROM category WHERE visible=1 ORDER BY `sequence`";
$rows = $pdo->query($sql)->fetchAll();

$cate = [];

// 拿到第一層
foreach ($rows as $r) {
    if ($r['parent_sid'] == 1) {
        $cate[] = $r;
    }
}

// 再跑第二層
foreach ($cate as $k => $c) {
    //這邊的$rows跟上面的不相干，這邊$rows變數設定給
    foreach ($rows as $k2 => $r) {
        // 如果c是r的子結點
        if ($c['sid'] == $r['parent_sid']) {
            $cate[$k]['children'][] = $r;
        }
    }
};

// echo json_encode($cate, JSON_UNESCAPED_UNICODE);
// exit;



?>



<?php include __DIR__ . '/1_parts/1_head.php'; ?>

<!-- 引入自己的ＣＳＳ -->
<link rel="stylesheet" href="./css/4_productList-filter.css">

<!-- 引入navbar -->
<?php include __DIR__ . '/1_parts/2_navbar.php'; ?>


<div class="bg">
    <!-- nav的高度空出來 -->
    <div class="space"></div>
    <div class="container">
        <!-- 麵包屑 -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="0_index.php">首頁</a></li>
                <li class="breadcrumb-item"><a href="4_productList.php">商品列表</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>

        <!-- 大圖輪播 -->
        <!-- Banner輪播 -->
        <div class="pic mb-3">
            <div id="carouselExampleIndicators" class="carousel slide p-0 position-relatve" data-ride="carousel">
                <!-- 固定的搜尋區塊 -->
                <div class="filter-wrap position-absolute col-8 col-md-8 col-sm-11 col-11">
                    <div class="filter-bg text-white text-center py-3">
                        <div class="event-search w-100 d-flex flex-column justify-content-between">
                            <h1 class="mb-3">最棒的活動，都在KunstHaus</h1>
                            <h5 class="">來找活動吧</h5>

                        </div>


                    </div>


                </div>

                <!-- 下面的小橫線 -->
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                </ol>
                <!-- 圖片 -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="imgs/banner/art-1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="imgs/banner/bg-attatch-2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="imgs/banner/b-4.jpg" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="imgs/banner/b-5.jpg" alt="Four slide">
                    </div>
                </div>
            </div>
        </div>

        <!-- 搜尋結果 -->
        <div class="col py-3">
            <h1>搜尋結果
                <b class="search-result text-white">" <?= $cate['0']['categories'] ?> "</b>
            </h1>
        </div>

        <!-- 內容開始 -->
        <div class="row">
            <!-- 篩選區塊 -->
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="filter-container">

                    <!-- 篩選 -->
                    <div class="accordion" id="accordionExample">

                        <!-- 篩選一 -->
                        <div class="filter-btn card area_item" data-sid="0">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-name="所有商品">
                                        所有商品
                                    </button>
                                </h2>
                            </div>


                            <!-- cate -->
                            <?php foreach ($cate as $k => $c) : ?>
                                <div class="filter-btn card area_item" data-sid="<?= $c['sid'] ?>">
                                    <div class="card-header" id="headingOne<?= $c['sid'] ?>">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne<?= $c['sid'] ?>" aria-expanded="true" aria-controls="collapseOne<?= $c['sid'] ?>" data-name="<?= $c['categories'] ?>">
                                                <?= $c['categories'] ?>
                                            </button>
                                        </h2>
                                    </div>

                                    <!-- dropdown -->

                                    <div id="collapseOne<?= $c['sid'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">

                                        <?php foreach ($c['children'] as $c2) : ?>
                                            <div class="card-body area_item" data-sid="<?= $c2['sid'] ?>" data-name=" <?= $c2['categories'] ?>">
                                                <?= $c2['categories'] ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>


                                </div>

                            <?php endforeach; ?>
                        </div>



                    </div>
                </div>
            </div>


            <!-- 產品列表 -->
            <div class="pd-wrap col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row product-list">


                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog col-lg-4 col-md- col-sm-11 col-11">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- body內容 -->
                        <div class="modal-body">
                            <!-- 這邊設定iframe -->
                            <iframe src="4_productList-modal-api.php?sid=1">
                            </iframe>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>




    <?php include __DIR__ . '/1_parts/3_script.php'; ?>

    <!-- 引入自己的ＪＳ -->
    <script>
        // 改變搜尋結果內容文字
        $('.card-header').on('click', function() {
            $(this).css('background-color', '#ffc024')
            $(this).closest('.filter-btn').siblings().find('.card-header').css('background-color', 'rgba(0, 0, 0, 0.03)')

            // 改變搜尋字
            $(this).find('.btn').text()
            const text = $(this).find('.btn').attr('data-name')
            // console.log(text)
            $('.search-result').text('" ' + text + ' "')
        });

        $('.card-body').on('click', function() {
            // console.log($(this).attr('data-name'))
            $(this).css('background-color', '#ffdd85')
            $(this).siblings().css('background-color', 'white')

            // 抓文字
            const text = $(this).attr('data-name')
            $('.search-result').text('" ' + text + ' "')

        });

        let likes = [];

        // 前端樣板小卡，先生成一個html的樣板字串格式
        const productTpl = function(a) {
            const sYear = a.start_datetime.slice(0, 4);
            const sDate = a.start_datetime.slice(5, 11);
            const eDate = a.end_datetime.slice(5, 11);
            let heart = '';
            if (likes && likes.length) {
                if (likes.includes(a.sid)) {
                    heart = "liked"
                }
            }

            return `     <div class="event-card mb-5 col-lg-6 col-md-6 col-sm-12 col-12" data-sid="${a.sid}">

<a href="4_product-detail.php?sid=${a.sid}" target="_blank" class="flip-card">
    <div class="flip-card-inner position-relative">
        <div class="flip-card-front img-wrap mb-3 position-relative position-absolute">
            <img src="imgs/event/event-sm/${a.picture}.jpg" class="card-img-top" alt="">
            <!-- 圖片上時間 -->
            <div class="time position-absolute p-2">
                <!-- 年 -->
                <div class="year">${sYear}</div>
                <!-- start -->
                <div class="start">${sDate}</div>
                <!-- end -->
                <div class="end">${eDate}</div>
            </div>
        </div>

        <div class="flip-card-back position-absolute p-3">
            <div class="filp-title mb-3 text-center"> 活動簡介</div>
            <p class="px-3">${a.event_info}</p>
            <div class="px-3 text-right mt-2 text-white">查看詳細介紹 >></div>

        </div>
    </div>
</a>


<div class="wrap mt-1 d-flex">
    <div class="card-body d-flex p-0 w-100">
        <div class="card-info position-relative m-auto py-3 col-10">
            <div class="event-name mb-2">${a.event_name}</div>

            <div class="event-location mb-2">
                <i class="fas fa-map-marker-alt"></i>
                ${a.location}</div>

            <div class="now-price">$ ${a.price}</div>

        
            <a href="Javascript:" class="like-link position-absolute">
                <i class="like like-btn far fa-heart ${heart}" data-sid="${a.sid}"></i>
            </a>

        </div>

   
        <a href="javascript:showProductModal(${a.sid})" class="card-price py-3 col-2 d-flex justify-content-center align-items-center">
            <i class="fas fa-cart-plus"></i>
        </a>

    </div>
</div>
</div>`;
        }

        function whenHashChanged() {
            // slice是不要前面的＃
            let u = location.hash.slice(1);
            console.log(u);
            // if (u == '2') {
            //     '5,6,7'
            // }
            getProductData(u);


            // TBD:改變外觀的事情讓whenhashchange來做

        }

        //事件處理器的event type，也就是這邊的’hashchange‘，全部都小寫，不會有大寫的
        window.addEventListener('hashchange', whenHashChanged);
        whenHashChanged();

        // JQ寫法抓sid，這邊要挪到最上面宣告，因為中間改選tag時會用到
        const cate_btns = $('.filter-btn');
        cate_btns.on('click', function(event) {
            const sid = $(event.target).closest('.area_item').attr('data-sid')
            // const sid = $(this).attr('data-sid') * 1;
            console.log(`sid: ${sid}`);
            location.href = "#" + sid;

        });

        // 拿資料的function
        function getProductData(cate = 0) {
            $.get('4_productList-filter-api.php', {
                cate: cate
            }, function(data) {
                console.log(data);

                // 呼叫小卡function，它會用回圈設定給出html字串
                let str = '';
                // 這邊的if是為了防止api沒撈到資料，先檢查一下
                if (data.products && data.products.length) {
                    data.products.forEach(function(el) {
                        str += productTpl(el);
                    });
                }

                // 拿到html字串後，再把所有商品串起來
                $('.product-list').html(str);



            }, 'json');
        }

        // modal
        function showProductModal(sid) {
            // 去抓當個sid
            $('iframe')[0].src = '4_productList-modal-api.php?sid=' + sid;

            $('#exampleModal').modal('show')

        }

        function updateCartCount() {
            //nav bar 呼叫的方法
        }


        // 搜尋下拉框呈現
        $('#search-event').on('click', function() {
            $('.search-dropdown').toggle();

        });


        // 收藏功能
        const sess_user = <?= json_encode($_SESSION['user'] ?? []) ?>;
        const like_btns = $('.like-btn');
        like_btns.click(function() {
            if (!sess_user.sid) {
                console.log('請先登入');

            } else {
                const card = $(this).closest('.event-card');
                const sid = card.attr('data-sid');
                const sendObj = {
                    action: 'like',
                    sid: sid,
                }
                console.log(sendObj)
                $.get('4.likes-api.php', sendObj, function(data) {
                    console.log(data);
                    if (data.success) {
                        card.find('.like-btn').addClass('liked');
                    } else {
                        card.find('.like-btn').removeClass('liked');
                    }

                }, 'json');
            }

        });
    </script>

    <?php include __DIR__ . '/1_parts/4_footer.php'; ?>