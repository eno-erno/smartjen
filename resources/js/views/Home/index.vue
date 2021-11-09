<template>
<div>
  <section class="banner py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-sm-6">
          <h3 class="fw-bold text-white mb-5">Education made easy when you can prepare, generate and share worksheets with just a few clicks.</h3>
          <button @click="handleClick" class="btn btn-light btn-outline-primary my-2 my-sm-0 mx-2 ml-5 font-schedule-intro size-btn">Schedule a demo</button>
        </div>
        <div class="col-12 col-sm-6">
          <img src="https://www.smartjen.com/img/smartjenAssets/Group1726.png" style="width:80%" alt="">
        </div>
      </div>
    </div>
  </section>
  <section class="feature pt-5">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center text-white">
          <h1>Our Features</h1>
          <p>Simple yet sophisticated! Create worksheets of different academic levels,</p>
          <p>topics and difficulties with just a few easy steps! </p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-4 mb-4">
          <div class="card bg-transparent text-center text-white px-3 py-5 border-white">
            <img src="https://www.smartjen.com/img/smartjenAssets/icons/WG.png" class="mx-auto mb-4 mt-5" style="width:4rem" alt="">
            <h4>Worksheet Generator</h4>
            <p>Easy creation and customisation of personalised worksheets each of unique levels of challenge with just the push of a button.</p>
          </div>
        </div>
        <div class="col-12 col-sm-4 mb-4">
          <div class="card bg-transparent text-center text-white px-3 py-5 border-white">
            <img src="https://www.smartjen.com/img/smartjenAssets/icons/OA.png" class="mx-auto mb-4 mt-5" style="width:4rem" alt="">
            <h4>Online Access</h4>
            <p>Left your worksheet behind? Create a new one or load a saved copy in just a few minutes from the cloud. Access the worksheets and progress reports wherever and whenever you want.</p>
          </div>
        </div>
        <div class="col-12 col-sm-4 mb-4">
          <div class="card bg-transparent text-center text-white px-3 py-5 border-white">
            <img src="https://www.smartjen.com/img/smartjenAssets/icons/OA.png" class="mx-auto mb-4 mt-5" style="width:4rem" alt="">
            <h4>Personalised Learning</h4>
            <p>Learning is personal. Utilise the tailored suggestions from the system to select the most appropriate questions based on your student’s performance.</p>
          </div>
        </div>
        <div class="col-12 col-sm-4 mb-4">
          <div class="card bg-transparent text-center text-white px-3 py-5 border-white">
            <img src="https://www.smartjen.com/img/smartjenAssets/icons/OrQB.png" class="mx-auto mb-4 mt-5" style="width:4rem" alt="">
            <h4>Organised Questionbank</h4>
            <p>Thousands of unique questions curated by seasoned educators based on a framework for heuristic based teaching. Never have to ask the same question twice!</p>
          </div>
        </div>
        <div class="col-12 col-sm-4 mb-4">
          <div class="card bg-transparent text-center text-white px-3 py-5 border-white">
            <img src="https://www.smartjen.com/img/smartjenAssets/icons/OrQB.png" class="mx-auto mb-4 mt-5" style="width:4rem" alt="">
            <h4>Handwriting Recognition</h4>
            <p>Automated marking open-ended questions! Using advanced AI handwriting technology, simply convert any digital handwriting from students into text for auto marking or your review!</p>
          </div>
        </div>
        <div class="col-12 col-sm-4 mb-4">
          <div class="card bg-transparent text-center text-white px-3 py-5 border-white">
            <img src="https://www.smartjen.com/img/smartjenAssets/icons/CVid.png" class="mx-auto mb-4 mt-5" style="width:4rem" alt="">
            <h4>Content & Videos</h4>
            <p>Personalise your teaching with approach with different types of content! Use videos, images and many more to suit your pedagogy and complete the teaching process!</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</template>
<script>
  export default {
    methods:{
      handleClick(){
        this.$router.push('/login')
      }
    },
    created() {
      document.title = "Welcome SmartJen";
    },
  }
</script>
<style scoped>
  .feature{background: linear-gradient(233.37deg, #302574 23.58%, #4DBEFB 122.91%);}
  .card{height: 25.4rem !important;}
  .banner{background: url('https://www.smartjen.com/img/smartjenAssets/vector1.png');}
  .font-schedule-intro {font-family: Source Sans Pro;font-style: normal;font-weight: 600;font-size: 16px;color: #0FB0F8 !important;border-color: #0FB0F8 !important;}
  .size-btn {width: 183px;height: 56px;}
  .font-schedule-intro:hover {background-color: #0FB0F8;color: white !important;}
</style>