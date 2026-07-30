<template>
  <div class="pricing-tier">
    <div class="pricing-tier__card">
      <div class="pricing-tier__header">
        <h3 class="pricing-tier__plan-name">{{ data?.plan_name }}</h3>
        <div class="pricing-tier__price">{{ data?.price }}</div>
      </div>
      <ul v-if="data?.features?.length" class="pricing-tier__features">
        <li v-for="(feature, index) in data.features" :key="index" class="pricing-tier__feature">
          <q-icon name="check_circle" color="positive" />
          <span>{{ feature }}</span>
        </li>
      </ul>
      <q-btn
        v-if="data?.cta_text"
        :label="data.cta_text"
        :href="data?.cta_link"
        color="deep-purple"
        class="pricing-tier__cta"
        no-caps
        rounded
        size="lg"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<style scoped>
.pricing-tier {
  padding: 1rem;
}

.pricing-tier__card {
  background: linear-gradient(145deg, #1e293b, #0f172a);
  border-radius: 1.5rem;
  padding: 2rem;
  border: 1px solid rgba(129, 140, 248, 0.2);
  text-align: center;
  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease;
}

.pricing-tier__card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 40px rgba(99, 102, 241, 0.2);
}

.pricing-tier__header {
  margin-bottom: 1.5rem;
}

.pricing-tier__plan-name {
  font-size: 1.5rem;
  font-weight: 600;
  color: #f8fafc;
  margin: 0 0 0.5rem 0;
}

.pricing-tier__price {
  font-size: 2.5rem;
  font-weight: 700;
  background: linear-gradient(135deg, #818cf8, #c084fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.pricing-tier__features {
  list-style: none;
  padding: 0;
  margin: 0 0 2rem 0;
  text-align: left;
}

.pricing-tier__feature {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 0;
  color: #e2e8f0;
  border-bottom: 1px solid rgba(148, 163, 184, 0.1);
}

.pricing-tier__feature:last-child {
  border-bottom: none;
}

.pricing-tier__cta {
  width: 100%;
  font-weight: 600;
}
</style>
