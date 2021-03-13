<template>
  <div class="columns is-vcentered">
    <div class="column">
      <p>Dans le cadre du projet de plantation de ripisylve dans le département du Doubs, FNE 25-90 et la Fédération de Pêche du Doubs ont besoin de <strong>repérer les sites nécessitant une reforestation de bord de rivière</strong>. Pour cela, un questionnaire ouvert à tout public est diffusé.</p>
      <div class="notification is-info is-flex" style="align-items: center">
        <div><b>Objectif :</b> Repérer les sites en bord de rivière présentant des linéaires de berge nue afin de cibler les sites prioritaires pour une plantation de ripisylve.</div>
      </div>
    </div>
    <div class="column">
      <p>Exemple de sites en bord de rivière&nbsp;:</p>
      <div class="columns">
        <div class="column">
          <div class="has-text-centered has-text-weight-bold">Sans ripisylve</div>
          <img src="/images/sans-ripisylve.jpg" alt="sans ripisylve" />
        </div>
        <div class="column">
          <div class="has-text-centered has-text-weight-bold">Avec ripisylve</div>
          <img src="/images/avec-ripisylve.jpg" alt="avec ripisylve" />
        </div>
      </div>
    </div>
  </div>
  <div class="has-text-right">
    <router-link :to="{ name: 'observation' }" class="button is-success is-large">Signaler un site &#8250;</router-link>
  </div>
  <h2 class="is-size-6 has-text-weight-bold mt-4">Données personnelles</h2>
  <div class="has-text-justified is-size-7 mt-1">Les informations recueillies sur ce formulaire sont enregistrées dans un fichier informatisé par FNE 25-90. Elles sont traitées dans le cadre du programme de plantation de FNE 25-90 et de la fédération de pêche du Doubs et conservées pendant une période de 5 ans. Les données personnelles ne sont pas communiquées à des tiers.</div>
  <div class="has-text-justified is-size-7 mt-1">Conformément à la Loi Informatique et Libertés, vous disposez d'un droit d'accès, modification et suppression de vos données personnelles. Pour exercer ce droit, contacter FNE 25-90 par voie postale au 7 Rue Voirin 25000 BESANCON ou <a href="javascript:window.location.href=atob('bWFpbHRvOmhlcmlzc29uQGZuZTI1OTAub3Jn')">par e-mail</a>.</div>
</template>