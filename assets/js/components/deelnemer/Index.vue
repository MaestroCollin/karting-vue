<template>
    <div>
<section >
    <table class="table" style="table-layout: fixed" >
        <caption>
            Dit zijn alle beschikbare activiteiten
        </caption>
        <thead>
        <tr>
            <td>datum</td>
            <td>tijd</td>
            <td>soort activiteit</td>
            <td>prijs</td>
            <td>Max deelnemers</td>
            <td>schrijf in</td>
        </tr>
        </thead>
        <tbody>
  
        <tr v-for="beschikbaar in beschikbare" :key="beschikbaar.id">
            <td>
               {{beschikbaar.datum}}
            </td>
            <td>
              {{beschikbaar.tijd}}
            </td>

            <td>
             {{beschikbaar.soort.naam}}
            </td>
            <td>
                &euro;{{beschikbaar.soort.prijs}}
            </td>
            <td>{{beschikbaar.soort.maxDeelnemers}}</td>
            <td title="schrijf in voor activiteit">

                
                   <a href="#" @click="inschrijven(beschikbaar.id)" >
                    <span class="glyphicon glyphicon-plus" style="color:red"></span>
                </a>
               
            </td>
        </tr>
     
                <tr class="text-danger">
                    <td>
                  
                    </td>
                    <td>
                    
                    </td>
                
                    <td>
               
                    </td>
                    <td>
                       
                    </td>
                    <td></td>
                    <td title="schrijf in voor activiteit">
                    </td>
                </tr>
   
        </tbody>
    </table>

    <table class="table" style="table-layout: fixed">
        <caption>
            Dit zijn de door jou ingeschreven activiteiten
        </caption>
        <thead>
        <tr>
            <td>datum</td>
            <td>tijd</td>
            <td>soort activiteit</td>
            <td>prijs</td>
            <td>schrijf uit</td>
        </tr>
        </thead>
        <tbody>
    
            <tr v-for="ingeschreef in ingeschreven" :key="ingeschreef.id">
                <td>
                       {{ingeschreef.datum}}
                </td>
                <td>
                  {{ingeschreef.tijd}}
                </td>

                <td>
                   {{ingeschreef.soort.naam}}
                </td>
                <td>
                    &euro;    {{ingeschreef.soort.prijs}}
                </td>
                <td title="schrijf in voor activiteit">
                    <a href="#" @click="uitschrijven(ingeschreef.id)" >
                        <span class="glyphicon glyphicon-minus" style="color:red"></span>
                    </a>
                </td>

            </tr>
 
        <tr>
            <td>
            
            </td>
            <td>
             
            </td>
            <td>
                Totaal prijs:
            </td>
            <td>
                   {{totaal}}

            </td>
            <td>
            </td>
        </tr>

        </tbody>
    </table>
</section>
    </div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
  export default {
    name: "Home",
    data() {
        return {
            beschikbare: {},
            ingeschreven: {},
        }
    },
    computed: {
  totaal() {
    let totaal = 0;
    for (const item of this.ingeschreven) {
      totaal += parseInt(item.soort.prijs);
    }
    return totaal;
  }
},
    async created() {
        const response = await axios.get('/api/deelnemer')
        this.beschikbare = response.data[0]
        this.ingeschreven = response.data[1]
     
    },
    methods: {
        uitschrijven(id) {
            axios.get('/api/user/uitschrijven/' + id);
            const index = this.ingeschreven.findIndex(item => item.id === id);
            this.tijdelijk = this.ingeschreven.splice(index,  1)
            this.beschikbare.push(this.tijdelijk[0])
 
        },
         inschrijven(id) {
            axios.get('/api/user/inschrijven/' + id);
            const index = this.beschikbare.findIndex(item => item.id === id);
            this.tijdelijk = this.beschikbare.splice(index, 1)
            this.ingeschreven.push(this.tijdelijk[0])
        },
        
    }

  }
</script>

<style scoped>

</style>