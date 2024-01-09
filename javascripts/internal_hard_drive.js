'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('internal_hard_drive', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      Hard_drive_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      Hard_drive_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      Hard_drive_capacity_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'ihd_capacity',
          key: 'ID'
        }
      },
      Hard_drive_type_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'ihd_type',
          key: 'ID'
        }
      },
      Hard_drive_cache: {
        type: Sequelize.INTEGER
      },
      Hard_drive_form_factor_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'ihd_form_factor',
          key: 'ID'
        }
      },
      Hard_drive_interface_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'ihd_interface',
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

    await queryInterface.addConstraint('internal_hard_drive', {
      fields: ['Hard_drive_capacity_ID'],
      type: 'foreign key',
      name: 'fk_hard_drive_capacity_id',
      references: {
        table: 'ihd_capacity',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('internal_hard_drive', {
      fields: ['Hard_drive_type_ID'],
      type: 'foreign key',
      name: 'fk_hard_drive_type_id',
      references: {
        table: 'ihd_type',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('internal_hard_drive', {
      fields: ['Hard_drive_form_factor_ID'],
      type: 'foreign key',
      name: 'fk_hard_drive_form_factor_id',
      references: {
        table: 'ihd_form_factor',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('internal_hard_drive', {
      fields: ['Hard_drive_interface_ID'],
      type: 'foreign key',
      name: 'fk_hard_drive_interface_id',
      references: {
        table: 'ihd_interface',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('internal_hard_drive', 'fk_hard_drive_capacity_id');
    await queryInterface.removeConstraint('internal_hard_drive', 'fk_hard_drive_type_id');
    await queryInterface.removeConstraint('internal_hard_drive', 'fk_hard_drive_form_factor_id');
    await queryInterface.removeConstraint('internal_hard_drive', 'fk_hard_drive_interface_id');
    await queryInterface.dropTable('internal_hard_drive');
  }
};
