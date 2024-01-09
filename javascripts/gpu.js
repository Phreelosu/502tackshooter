'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('GPU', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      GPU_name: {
        allowNull: false,
        type: Sequelize.STRING(255)
      },
      GPU_price: {
        allowNull: false,
        type: Sequelize.DECIMAL(10, 2)
      },
      GPU_chipset: {
        type: Sequelize.STRING(255)
      },
      GPU_memory_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'GPU_Memory',
          key: 'ID'
        }
      },
      GPU_core_clock: {
        type: Sequelize.FLOAT
      },
      GPU_boost_clock: {
        type: Sequelize.FLOAT
      },
      GPU_color_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'colors',
          key: 'ID'
        }
      },
      GPU_length: {
        type: Sequelize.DECIMAL(5, 2)
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

    await queryInterface.addConstraint('GPU', {
      fields: ['GPU_memory_ID'],
      type: 'foreign key',
      name: 'fk_gpu_memory_id',
      references: {
        table: 'GPU_Memory',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('GPU', {
      fields: ['GPU_color_ID'],
      type: 'foreign key',
      name: 'fk_gpu_color_id',
      references: {
        table: 'colors',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('GPU', 'fk_gpu_memory_id');
    await queryInterface.removeConstraint('GPU', 'fk_gpu_color_id');
    await queryInterface.dropTable('GPU');
  }
};
