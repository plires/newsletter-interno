<!-- Ultimos 15 Newsletters -->
<section class="row">
  <div class="col-md-12">

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Últimos 15 Newsletters</h3>
      </div>

      <div class="card-body">
        <ul v-if="newslettersCurrentYear" class="pagination pagination-month justify-content-center">

          <li v-for="newsletter in newslettersCurrentYear" :key="newsletter.id" :class="['page-item', newsletterActive(newsletter.month, newsletter.year)]">
            <button class="page-link" @click="setCurrentNewsletter(newsletter.id, 'administracion_finanzas', 'preview_administracion_finanzas')">
                <p class="page-month">{{ newsletter.name_month }}</p>
                <p class="page-year">{{ newsletter.year }}</p>
            </button>
          </li>
        
        </ul>

        <p v-else>Aún no hay Newsletters cargados.</p>
      </div>
      
    </div>

  </div>
</section>
<!-- Ultimos 15 Newsletters end -->