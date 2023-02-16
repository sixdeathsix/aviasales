<?php if(isset($_SESSION['message'])): ?>
  <p id="toast" class="message"><?= $_SESSION['message']; ?></p>
  <?= '
    <script>
      function show() {
        let t = document.getElementById("toast");
        t.className = "show";
        setTimeout(() =>  t.className = t.className.replace("show", ""), 2000);
      }
      show();
    </script>
  ' ?>
<?php endif; unset($_SESSION['message']); ?>