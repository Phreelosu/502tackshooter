'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('motherboard', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      Motherboard_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      Motherboard_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      Motherboard_socket: {
        type: Sequelize.STRING(50)
      },
      Motherboard_form_factor_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'mobo_form_factor',
          key: 'ID'
        }
      },
      Motherboard_max_memory_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'mobo_max_memory',
          key: 'ID'
        }
      },
      Motherboard_memory_slots_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'mobo_memory_slots',
          key: 'ID'
        }
      },
      Motherboard_color_ID: {
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

    await queryInterface.addConstraint('motherboard', {
      fields: ['Motherboard_form_factor_ID'],
      type: 'foreign key',
      name: 'fk_motherboard_form_factor_id',
      references: {
        table: 'mobo_form_factor',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('motherboard', {
      fields: ['Motherboard_max_memory_ID'],
      type: 'foreign key',
      name: 'fk_motherboard_max_memory_id',
      references: {
        table: 'mobo_max_memory',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('motherboard', {
      fields: ['Motherboard_memory_slots_ID'],
      type: 'foreign key',
      name: 'fk_motherboard_memory_slots_id',
      references: {
        table: 'mobo_memory_slots',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('motherboard', {
      fields: ['Motherboard_color_ID'],
      type: 'foreign key',
      name: 'fk_motherboard_color_id',
      references: {
        table: 'colors',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('motherboard', 'fk_motherboard_form_factor_id');
    await queryInterface.removeConstraint('motherboard', 'fk_motherboard_max_memory_id');
    await queryInterface.removeConstraint('motherboard', 'fk_motherboard_memory_slots_id');
    await queryInterface.removeConstraint('motherboard', 'fk_motherboard_color_id');
    await queryInterface.dropTable('motherboard');
  }
};
