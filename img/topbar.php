<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
     <a class="navbar-brand" href="home.php" onmouseenter='style="background-color:black"' onmouseleave='style="background-color:#222222"'><img src="img/mangowhite.png" alt="mango.com" style="float:left;width:20px;height:20px;"> ManGO</a>
  </div>

  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories<span class="caret" ></span></a>
        <ul class="dropdown-menu">
                          <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=">All</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=100&catname=Notebook">Laptop</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=101&catname=Tablet">Tablet & Phone</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=102&catname=PC-Desktop">Desktop Computer</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=103&catname=Other">Other</a></li>

        </ul>
        </li>
   </ul>


   <!--- brands ------>

   <div id="navbar" class="navbar-collapse collapse">
     <ul class="nav navbar-nav">
       <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">Brands<span class="caret" ></span></a>
         <ul class="dropdown-menu">
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=1&braname=Apple">Apple</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=100&braname=Asus">Asus</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=101&braname=Acer">Acer</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=102&braname=MSI">Msi</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=104&braname=Dell">Dell</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=105&braname=Hp">hp</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=106&braname=Toshiba">Toshiba</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=107&braname=Samsung">Samsung</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=108&braname=Cisco">Cisco</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=109&braname=Tplink">Tp-link</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=110&braname=Dlink">D-link</a></li>

         </ul>
         </li>

       <li>
               <form method="get" class="navbar-form navbar-left" form action="searchpro.php">
                 <input type="text" class="form-control" placeholder="Search me" style="width:400px" name="q" maxlength="30" value="<?php echo stripslashes($_GET['q']); ?>" required>
               </form>
       </li>

    </ul>



       <ul class="nav navbar-nav navbar-right">
         <li><a href="how-to-order.php" class="glyphicon glyphicon-usd">Payments</a></li>

         <li><a href="order-history.php" class="glyphicon glyphicon-time">Orders</a></li>

         <li>
            <a href="login.php" class="btn btn-danger btn-sm">
            <font color="white"><span class="glyphicon glyphicon-log-in"></span> Sign in</font></a>
         </li>

         <li><a href="logout.php">Sign Out</a></li>

         <li><a href="order-cart.php" class="glyphicon glyphicon-shopping-cart">ตะกร้าสินค้า</a></li>

       </ul>

     </div>
   </div>
 </nav>
      <!-- end bar top-->
