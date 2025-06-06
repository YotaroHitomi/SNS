$(function () {
  $(".menu-trigger").on("click", function () {
    $(".acordion").slideToggle();
    $(this).toggleClass("open");
  });
});

// モーダル部分
$(function () {
  $('.modalopen').each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var modal = document.getElementById(target);
      console.log(modal);
      $(modal).fadeIn();
      return false;
    });
  });
  $('.modalClose').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});

// $(function () { // if document is ready
//   alert('hello world')
// });

$(function () {
  // 編集ボタン(class="js-modal-open")が押されたら発火
  $('.js-modal-open').on('click', function () {
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから投稿内容を取得し変数へ格納
    var post = $(this).attr('post');
    // 押されたボタンから投稿のidを取得し変数へ格納（どの投稿を編集するか特定するのに必要な為）
    var post_id = $(this).attr('post_id');

    // 取得した投稿内容をモーダルの中身へ渡す
    $('.modal_post').text(post);
    // 取得した投稿のidをモーダルの中身へ渡す
    $('.modal_id').val(post_id);
    return false;
  });

  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });
});

$(document).ready(function () {
  $('.update-button').on('click', function () {
    const postId = $(this).data('id');
    const postTitle = $(this).data('title');
    const postContent = $(this).data('content');

    $('#updateForm').attr('action', '/posts/' + postId);
    $('#title').val(postTitle);
    $('#content').val(postContent);
  });
});

// $(function () { // if document is ready
//   alert('hello world')
// });

$(function () {
  // 編集ボタンがクリックされた時にモーダルを開く
  $('.js-modal-open').on('click', function () {
    const postId = $(this).data('id'); // 投稿ID
    const postContent = $(this).data('content'); // 投稿内容

    // モーダルを表示
    $('.js-modal').fadeIn();

    // 投稿の内容とIDをフォームにセット
    $('#postId').val(postId);
    $('#postContent').val(postContent);

    return false; // デフォルトのリンク動作を無効化
  });

  // モーダルを閉じる処理
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});
