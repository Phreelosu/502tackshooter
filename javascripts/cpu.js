'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('CPU', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      CPU_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      CPU_core_count: {
        allowNull: false,
        type: Sequelize.INTEGER
      },
      CPU_core_clock: {
        type: Sequelize.FLOAT
      },
      CPU_boost_clock: {
        type: Sequelize.FLOAT
      },
      CPU_graphics: {
        type: Sequelize.STRING(255)
      },
      createdAt: {
        allowNull: false,
        type: Sequelize.DATE
      },
      updatedAt: {
        allowNull: false,
        type: Sequelize.DATE
      }
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.dropTable('CPU');
  }
};
