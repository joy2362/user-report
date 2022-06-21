Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'user-report',
      path: '/user-report',
      component: require('./components/Tool'),
    },
      {
          name: 'report-index',
          path: '/user-report/:type',
          component: require('./components/report/index'),
      },
      {
          name: 'report-view',
          path: '/user-report/:type/:id/view',
          component: require('./components/single-view/index'),
      },
  ])
})
