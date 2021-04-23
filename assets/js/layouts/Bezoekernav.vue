<template>
    <div>
        <div class="container" style="background-color: white">
<header>
            <div class="row" style="margin-top: 20px">

            <div class="hidden-xs col-sm-2 ">
                <img src='/build/images/logo.b78df324.png' alt="kartcentrum" class="pull-left img-responsive ">
            </div>
            <div class="col-sm-10">
                <h1>Kartcentrum <span class="text-danger"> MAX</span></h1>

            </div>

        </div>
</header>
         <nav class="navbar navbar-default" style="margin-bottom: 0px">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-fire"></span> </a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                        <li><router-link to="/">Home</router-link></li>
                        <li><router-link to="/aanbod">Aanbod</router-link></li>
                        <li><a href="">registreren</a></li>
                        <li><a href="#">contact</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="">inloggen</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <figure>
        <img style="margin-bottom: 20px" class="img-responsive" src='/build/images/kart-wide.356fbf8c.jpg' />
    </figure>

        <hr>
    <footer>

        <img class="pull-right img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px" src='/build/images/linkedin.1c61aebd.jpg' />
        <img class="pull-right img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px" src='/build/images/tweet.654f49ea.jpg' />
        <img class="pull-right img-thumbnail " width="40" style="margin-top: -10px;margin-bottom: 10px" src='/build/images/pinterest.f9da1ee3.png' />

        <p class="text-muted text-center">&copy;afdeling applicatieontwikkelaar Tinwerf 10, 2544 ED Den Haag.
            Telefoon:088 666 3600 </p>
    </footer>
    </div>
    </div>
</template>

<script>
  export default {
    name: "Bezoekernav"
  }
</script>

<style scoped>

</style>