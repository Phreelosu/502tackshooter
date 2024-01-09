'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('PC_case', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      Case_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      Case_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      Case_type_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'case_type',
          key: 'ID'
        }
      },
      Case_color_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'colors',
          key: 'ID'
        }
      },
      PSU_Watts: {
        type: Sequelize.INTEGER
      },
      Side_panel_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'side_panel_types',
          key: 'ID'
        }
      },
      Bay_count: {
        type: Sequelize.INTEGER
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

    await queryInterface.addConstraint('PC_case', {
      fields: ['Case_type_ID'],
      type: 'foreign key',
      name: 'fk_case_type_id',
      references: {
        table: 'case_type',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC_case', {
      fields: ['Case_color_ID'],
      type: 'foreign key',
      name: 'fk_case_color_id',
      references: {
        table: 'colors',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC_case', {
      fields: ['Side_panel_ID'],
      type: 'foreign key',
      name: 'fk_side_panel_id',
      references: {
        table: 'side_panel_types',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('PC_case', 'fk_case_type_id');
    await queryInterface.removeConstraint('PC_case', 'fk_case_color_id');
    await queryInterface.removeConstraint('PC_case', 'fk_side_panel_id');
    await queryInterface.dropTable('PC_case');
  }
};
