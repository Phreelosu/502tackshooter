'use strict';
/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('PC', {
      ID: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      Case_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'PC_case',
          key: 'ID'
        }
      },
      CPU_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'CPU',
          key: 'ID'
        }
      },
      CPU_Cooler_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'CPU_Cooler',
          key: 'ID'
        }
      },
      GPU_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'GPU',
          key: 'ID'
        }
      },
      IHD_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'internal_hard_drive',
          key: 'ID'
        }
      },
      Memory_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'memory',
          key: 'ID'
        }
      },
      Motherboard_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'motherboard',
          key: 'ID'
        }
      },
      PSU_ID: {
        type: Sequelize.INTEGER,
        references: {
          model: 'PSU',
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

    await queryInterface.addConstraint('PC', {
      fields: ['Case_ID'],
      type: 'foreign key',
      name: 'fk_pc_case_id',
      references: {
        table: 'PC_case',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['CPU_ID'],
      type: 'foreign key',
      name: 'fk_pc_cpu_id',
      references: {
        table: 'CPU',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['CPU_Cooler_ID'],
      type: 'foreign key',
      name: 'fk_pc_cpu_cooler_id',
      references: {
        table: 'CPU_Cooler',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['GPU_ID'],
      type: 'foreign key',
      name: 'fk_pc_gpu_id',
      references: {
        table: 'GPU',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['IHD_ID'],
      type: 'foreign key',
      name: 'fk_pc_ihd_id',
      references: {
        table: 'internal_hard_drive',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['Memory_ID'],
      type: 'foreign key',
      name: 'fk_pc_memory_id',
      references: {
        table: 'memory',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['Motherboard_ID'],
      type: 'foreign key',
      name: 'fk_pc_motherboard_id',
      references: {
        table: 'motherboard',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });

    await queryInterface.addConstraint('PC', {
      fields: ['PSU_ID'],
      type: 'foreign key',
      name: 'fk_pc_psu_id',
      references: {
        table: 'PSU',
        field: 'ID'
      },
      onDelete: 'cascade',
      onUpdate: 'cascade'
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.removeConstraint('PC', 'fk_pc_case_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_cpu_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_cpu_cooler_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_gpu_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_ihd_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_memory_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_motherboard_id');
    await queryInterface.removeConstraint('PC', 'fk_pc_psu_id');
    await queryInterface.dropTable('PC');
  }
};
