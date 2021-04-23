<template>
  <div>
    <section>
      <div class="row">
        <div class="col-lg-10">
          <h1>Profiel</h1>
        </div>
        <a href="/user/profile/password/change">
          <h4 style="margin-top: 25px">Wijzig wachtwoord</h4>
        </a>
      </div>
      <hr />
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-lg-10">
              <h3>Mijn gegevens</h3>
            </div>
            <div class="col-lg-2">
              <router-link to="/user/profile/change">
                <h4 style="margin-top: 25px">Wijzigen</h4>
              </router-link>
            </div>
          </div>

          <hr />
          <p>
            <b>Username:</b> {{ this.$user.username }}<br />
            <b>Email:</b> {{ this.$user.email }}<br />
            <b>Voorletters:</b> {{ this.$user.voorletters }}<br />
            <b>Tussenvoegsel:</b> {{ this.$user.tussenvoegsel }}<br />
            <b>Achternaam:</b> {{ this.$user.achternaam }}<br />
            <b>Adres:</b> {{ this.$user.adres }}<br />
            <b>Postcode:</b> {{ this.$user.postcode }}<br />
            <b>Woonplaats:</b> {{ this.$user.woonplaats }}<br />
            <b>Telefoon:</b> {{ this.$user.telefoon }}<br />
          </p>
        </div>
        <div class="col-lg-6">
          <h3>Mijn inschrijvingen</h3>
          <hr />
          <table class="table" style="table-layout: fixed">
            <thead>
              <tr>
                <td>Datum</td>
                <td>Tijd</td>
                <td>Activiteit</td>
                <td>Prijs</td>
              </tr>
            </thead>
            <tbody>
              <tr v-for="activiteit in activiteiten" :key="activiteit.id">
                <td>{{activiteit.datum}}</td>
                <td>{{activiteit.tijd}}</td>
                <td>{{activiteit.soort.naam}}</td>
                <td>{{activiteit.soort.prijs}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Profile",
  data() {
    return {
      activiteiten: {},
    };
  },
  async created() {
    const response = await axios.get("/api/user/activiteiten");
    this.activiteiten = response.data;
  },
  methods: {},
};
</script>

