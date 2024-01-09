'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('CPU_Cooler', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      Cooler_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      Cooler_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      Cooler_RPM: {
        type: Sequelize.INTEGER
      },
      Cooler_color_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'colors',
          key: 'ID'
        }
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

    await queryInterface.addConstraint('CPU_Cooler', {
      fields: ['Cooler_color_ID'],
      type: 'foreign key',
      name: 'fk_cooler_color_id',
      references: {
        table: 'colors',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('CPU_Cooler', 'fk_cooler_color_id');
    await queryInterface.dropTable('CPU_Cooler');
  }
};
