'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('PSU', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      PSU_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      PSU_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      PSU_type_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'psu_type',
          key: 'ID'
        }
      },
      PSU_efficiency_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'psu_efficiency',
          key: 'ID'
        }
      },
      PSU_watts: {
        type: Sequelize.INTEGER
      },
      Modular_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'PSU_Modular',
          key: 'ID'
        }
      },
      PSU_color_ID: {
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

    await queryInterface.addConstraint('PSU', {
      fields: ['PSU_type_ID'],
      type: 'foreign key',
      name: 'fk_psu_type_id',
      references: {
        table: 'psu_type',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PSU', {
      fields: ['PSU_efficiency_ID'],
      type: 'foreign key',
      name: 'fk_psu_efficiency_id',
      references: {
        table: 'psu_efficiency',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PSU', {
      fields: ['Modular_ID'],
      type: 'foreign key',
      name: 'fk_modular_id',
      references: {
        table: 'PSU_Modular',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PSU', {
      fields: ['PSU_color_ID'],
      type: 'foreign key',
      name: 'fk_psu_color_id',
      references: {
        table: 'colors',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('PSU', 'fk_psu_type_id');
    await queryInterface.removeConstraint('PSU', 'fk_psu_efficiency_id');
    await queryInterface.removeConstraint('PSU', 'fk_modular_id');
    await queryInterface.removeConstraint('PSU', 'fk_psu_color_id');
    await queryI
