'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('memory', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      Memory_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      Memory_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      Memory_speed: {
        type: Sequelize.INTEGER
      },
      Memory_modules_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'memory_modules',
          key: 'ID'
        }
      },
      Memory_color_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'colors',
          key: 'ID'
        }
      },
      First_word_latency: {
        type: Sequelize.INTEGER
      },
      CAS_latency: {
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

    await queryInterface.addConstraint('memory', {
      fields: ['Memory_modules_ID'],
      type: 'foreign key',
      name: 'fk_memory_modules_id',
      references: {
        table: 'memory_modules',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('memory', {
      fields: ['Memory_color_ID'],
      type: 'foreign key',
      name: 'fk_memory_color_id',
      references: {
        table: 'colors',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('memory', 'fk_memory_modules_id');
    await queryInterface.removeConstraint('memory', 'fk_memory_color_id');
    await queryInterface.dropTable('memory');
  }
};
