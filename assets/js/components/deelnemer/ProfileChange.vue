<template>
  <div>
    <form v-on:submit="change">
      <input type="text" class="form-control" :value="this.$user.username"/>
      <input type="text" class="form-control" :value="this.$user.email"/>
      <input  type="text" class="form-control" :value="this.$user.voorletters"/>
      <input  type="text" class="form-control" :value="this.$user.tussenvoegsel"/>
      <input type="text" class="form-control" :value="this.$user.achternaam"/>
      <input  type="text" class="form-control" :value="this.$user.adres"/>
      <input  type="text" class="form-control" :value="this.$user.postcode"/>
      <input  type="text" class="form-control" :value="this.$user.woonplaats"/>
      <input type="text" class="form-control" :value="this.$user.telefoon"/>
      <input type="submit" class="btn btn-primary" value="Veranderen" />
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "ProfileChange",
  data() {
    return {
        response: {}
    };
  },
  async created() {},
  methods: {
    change(e) {
      e.preventDefault();

      var user = {
        username: e.srcElement[0].value,
        email: e.srcElement[1].value,
        voorletters: e.srcElement[2].value,
        tussenvoegsel: e.srcElement[3].value,
        achternaam: e.srcElement[4].value,
        adres: e.srcElement[5].value,
        postcode: e.srcElement[6].value,
        woonplaats: e.srcElement[7].value,
        telefoon: e.srcElement[8].value,
      };
      axios.post("/api/user/profile/change", user)
      .then(response => this.response = response.data)
      if(this.response === 204){
         this.$router.push('/user/profile')
      }
    },
  },
};
</script>

