<star-rating inline-template>
  <div class="star-rating">
    <p>Rate recipe:</p>
    <button @click="rate(0)">
      <svg><path d="..." :fill="rating === 0 ? 'black' : 'transparent'"></svg>
    </button>
    <button v-for="(i in 5)" @click="rate(i)">
      <svg><path d="..." :fill="rating >= i ? 'black' : 'transparent'"></svg>
    </button>
  </div>
</star-rating>