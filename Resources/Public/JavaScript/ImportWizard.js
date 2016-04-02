/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Module: TYPO3/CMS/Wpimport/ImportWizard
 */
define(['jquery', 'TYPO3/CMS/Backend/Wizard', 'TYPO3/CMS/Backend/Severity'], function($, Wizard, Severity) {
    'use strict';

    var ImportWizard = {
        selector: '#rootwizard',
        selectorButton: '.t3js-action-start-import',
        importTasks: ['categories', 'attachments', 'pages', 'tags', 'posts'],
        selectedImportTasks: []
    };

    ImportWizard.initialize = function() {
        $(document).on('click', ImportWizard.selectorButton, ImportWizard.initializeWizard);
    };

    ImportWizard.initializeWizard = function() {
        Wizard.addSlide(
            'import-step1',
            'Import Wizard',
            ImportWizard.getContent('intro'),
            Severity.info,
            ImportWizard.initializeStep1
        );
        for (var i=0; i<ImportWizard.importTasks.length; i++) {
            var taskName = ImportWizard.importTasks[i];
            Wizard.addSlide(
                'import-' + taskName,
                'Import Wizard: ' + taskName,
                ImportWizard.getContent('task-' + taskName),
                Severity.info,
                ImportWizard.initializeTask
            );
        }
        Wizard.addFinalProcessingSlide(function() {
            // finalize here
            Wizard.dismiss();
        }).done(function() {
            Wizard.show();
        });
    };

    ImportWizard.initializeStep1 = function($slide) {
        console.log('initializeStep1');
        ImportWizard.selectedImportTasks = [];
        $slide.find('input[type="checkbox"]').on('click', function() {
            if ($(this).prop('checked')) {
                ImportWizard.selectedImportTasks.push($(this).attr('name'));
            } else {
                ImportWizard.selectedImportTasks.remove($(this).attr('name'));
            }
        });
        Wizard.unlockNextStep();
    };

    ImportWizard.initializeTask = function($slide) {
        console.log($slide);
        var task = '???'; // @TODO: How to get identifier from $slide?
        if (ImportWizard.inArray(task, ImportWizard.selectedImportTasks)) {
            console.log('selected task');
        } else {
            console.log('not selected task');
        }
        Wizard.unlockNextStep();
    };

    ImportWizard.inArray = function(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    };

    ImportWizard.getContent = function(slide) {
        return $('#wizard-content-' + slide).html();
    };

    $(function() {
        Array.prototype.remove = function() {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };
        ImportWizard.initialize();
    });
});