<template>
    <div>
        <section >
        <article>
            <h3>Er zijn {{aanbods.length}} soorten activiteiten </h3>
           
            <ul class="list-group" >
               <li v-for="aanbod in aanbods" class="list-group-item text-primary" :key="aanbod.id">{{aanbod.naam}} - Prijs: {{aanbod.prijs}} - Tijdsduur: {{aanbod.tijdsduur}}min. - Minimum leeftijd: {{aanbod.min_leeftijd}} jaar</li>
            </ul>
            <hr>
            <h3>Huidige activiteiten</h3>
            <ul class="list-group">
                <li :key="huidig.id" class="list-group-item text-primary"  v-for="huidig in huidige">{{ huidig.soort.naam }} - {{huidig.datum}} om {{huidig.tijd}} - Prijs: {{huidig.soort.prijs}} - tijdsduur: {{huidig.soort.tijdsduur}} min. - minimum leeftijd: {{huidig.soort.minLeeftijd}} jaar</li>
            </ul>
            <p>
                Let op, voor het karten zijn dichte schoenen verplicht.
                Karten met een korte broek is niet toegestaan. Wij hebben overalls ter beschikking,
                maar probeer indien mogelijk een lange broek aan te doen of mee te nemen.
            </p>
        </article>
        <figure>
            <img class="img-responsive center-block" style="width:30%" src='/build/images/kart.0133f146.jpg' alt="kart" />
        </figure>
    </section>
    </div>

</template>

<script>
    import axios from 'axios'

  export default {
      
    name: "Aanbod",
    data() {
        return {
            aanbods: {},
            huidige: {},
            user: {},
        }
    },
    async created() {
        const response = await axios.get('/aanbodapi')
        this.aanbods = response.data[0]
        this.huidige = response.data[1]
        console.log(this.$user)
    },

  }
</script>

<style scoped>

</style>