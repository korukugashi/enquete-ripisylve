<template>
  <h2 class="title is-4 sohoma">Informations sur le lieu</h2>
  <div class="columns mt-1">
    <div class="column is-5">
      <div class="field">
        <label class="label" for="address">Recherchez l'adresse&nbsp;<span v-if="!form.lat">*</span></label>
        <div class="control">
          <autocomplete
            id="address"
            initValue=""
            anchor="label"
            :debounce="300"
            placeholder="Rechercher une adresse"
            :classes="{ input: 'input', list: 'data-list', item: 'data-list-item' }"
            :on-select="selectAdresse"
            :onInput="clearAdresse"
            :onShouldGetData="getAdresse"
          />
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label">Corrigez si nécessaire l'emplacement sur la carte</label>
        <div class="control">
          <map-locator />
        </div>
      </div>
    </div>
  </div>
  <h2 class="title is-4 sohoma">Vos photos</h2>
  <p>Veuillez joindre une ou plusieurs photographie(s) du lieu.</p>
  <div class="columns is-vcentered">
    <div class="column is-narrow">
      <div class="file is-boxed" v-if="form.photos.length < 6">
        <label class="file-label">
          <input class="file-input" type="file" ref="file" accept="image/jpeg" capture="environment" @change="selectFile">
          <span class="file-cta">
            <img src="/icons/upload.svg" alt="Ajouter une photo" style="width: 70px" />
            <span class="file-label mt-3 has-text-weight-bold">
              Ajouter une photo
            </span>
          </span>
        </label>
      </div>
      <div v-else class="is-italic">6 photos maximum</div>
    </div>
    <div class="column">
      <div class="is-flex is-flex-wrap-wrap">
        <figure class="image is-128x128 mr-3" v-for="photo in form.photos" :key="photo" style="position: relative">
          <img :src="photo" alt="" />
          <button class="delete" @click="removeFile(photo)" style="position: absolute; top: 5px; right: 5px"></button>
        </figure>
      </div>
    </div>
  </div>
  <h2 class="title is-4 sohoma">Vos coordonnées</h2>
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label" for="firstname">Prénom&nbsp;*</label>
        <div class="control">
          <input class="input" id="firstname" type="text" v-model="form.firstname" placeholder="Votre prénom" required />
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label" for="name">Nom&nbsp;*</label>
        <div class="control">
          <input class="input" id="name" type="text" v-model="form.name" placeholder="Votre nom" required />
        </div>
      </div>
    </div>
  </div>
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label" for="email">Adresse email&nbsp;*</label>
        <div class="control">
          <input class="input" id="email" type="email" v-model="form.email" placeholder="Votre adresse email" />
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label" for="phone">Téléphone</label>
        <div class="control">
          <input class="input" id="phone" type="text" v-model="form.phone" placeholder="Votre numéro de téléphone" />
        </div>
      </div>
    </div>
  </div>
  <h2 class="title is-4 sohoma">Les coordonnées du propriétaire (si connues)</h2>
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label" for="propFirstname">Prénom</label>
        <div class="control">
          <input class="input" id="propFirstname" type="text" v-model="form.propFirstname" placeholder="Votre prénom" required />
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label" for="propName">Nom</label>
        <div class="control">
          <input class="input" id="propName" type="text" v-model="form.propName" placeholder="Votre nom" required />
        </div>
      </div>
    </div>
  </div>
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label" for="propEmail">Adresse email</label>
        <div class="control">
          <input class="input" id="propEmail" type="email" v-model="form.propEmail" placeholder="Votre adresse email" />
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label" for="propPhone">Téléphone</label>
        <div class="control">
          <input class="input" id="propPhone" type="text" v-model="form.propPhone" placeholder="Votre numéro de téléphone" />
        </div>
      </div>
    </div>
  </div>
  <h2 class="title is-4 sohoma">Vos remarques</h2>
  <div class="field">
    <div class="control">
      <textarea class="textarea" id="remarks" v-model="form.remarks"></textarea>
    </div>
  </div>
  <div class="is-flex mt-5" style="justify-content: space-between; align-items: center">
    <router-link :to="{ name: 'home' }" class="button">&#8249; Précédent</router-link>
    <router-link :to="{ name: 'confirm' }" class="button is-success is-large" :class="{'is-disabled': isNextDisabled}" @click="clickWard">Suivant &#8250;</router-link>
  </div>
  <div class="notification is-warning mt-5" v-if="isNextDisabled">Veuillez renseigner tous les champs obligatoires (marqués d'une *)</div>
</template>

<script>
import { inject } from "vue";
import axios from "axios";

import MapLocator from "./MapLocator.vue";
import Autocomplete from "./Autocomplete.vue";
import SelectCard from './SelectCard.vue';

export default {
  components: { MapLocator, Autocomplete, SelectCard },
  setup() {
    const form = inject("form");
    return { form };
  },
  created() {
    if (navigator.geolocation && !this.form.lon) {
      navigator.geolocation.getCurrentPosition(position => {
        this.form.lat  = position.coords.latitude;
        this.form.lon = position.coords.longitude;
      }, () => {});
    }
  },
  computed: {
    isNextDisabled() {
      return !this.form.date || !this.form.heure || !this.form.lat || !this.form.lon ||
        !this.form.photos.length || !this.form.name || !this.form.firstname || !this.form.email ||
        !this.form.email.match(
          /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    }
  },
  methods: {
    selectAdresse: function (value) {
      this.form.adresse = value.label;
      this.form.codePostal = value.postcode;
      this.form.lat = value.lat;
      this.form.lon = value.lon;
    },
    clearAdresse:  function () {
      this.form.adresse = null;
      this.form.codePostal = null;
      this.form.lat = null;
      this.form.lon = null;
    },
    getAdresse: async function (val) {
      if (val.length < 2) return [];
      try {
        const apiResponse = await axios.get("https://api-adresse.data.gouv.fr/search", { params: { q: val } })
        return apiResponse.data && apiResponse.data.features.map(feature => feature.properties ? ({
          label: feature.properties.label,
          postcode: feature.properties.postcode,
          lon: feature.geometry.coordinates[0],
          lat: feature.geometry.coordinates[1],
        }) : { label: "Erreur", x: 0, y: 0 });
      } catch (error) {
        alert("Une erreur s'est produite lors de la recherche de l'adresse, veuillez réessayer plus tard ou nous contacter.");
        return [];
      }
    },
    clickWard(e) {
      if (this.isNextDisabled) {
        e.preventDefault();
      }
    },
    selectFile() {
      const url = window.URL.createObjectURL(this.$refs.file.files.item(0));
      this.form.photos = this.form.photos.concat([url]);
    },
    removeFile(file) {
      this.form.photos = this.form.photos.filter(item => item !== file);
      window.URL.revokeObjectURL(file);
    },
  }
};
</script>
