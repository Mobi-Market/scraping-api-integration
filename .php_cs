<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests/Feature')
    ->exclude('tests/Unit')
    ->exclude('vendor')
    ->exclude('Artifacts')
    ->exclude('bootstrap')
    ->exclude('storage')
    ->exclude('public')
    ->exclude('reports')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('_ide_helper.php');

$config = PhpCsFixer\Config::create()
    ->setFormat('checkstyle')
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony'                                      => true,
        '@Symfony:risky'                                => true,
        '@PSR1'                                         => true,
        '@PSR2'                                         => true,
        '@PHP71Migration:risky'                         => true,
        '@PHP71Migration'                               => true,
        '@PHP70Migration:risky'                         => true,
        '@PHP70Migration'                               => true,
        '@PHP56Migration:risky'                         => true,
        '@PHP56Migration'                               => true,
        'align_multiline_comment'                       => true,
        'array_indentation'                             => true,
        'array_syntax'                                  => ['syntax' => 'short'],
        'blank_line_before_statement'                   => true,
        'combine_consecutive_issets'                    => true,
        'combine_consecutive_unsets'                    => true,
        'compact_nullable_typehint'                     => true,
        'comment_to_phpdoc'                             => true,
        'explicit_indirect_variable'                    => true,
        'explicit_string_variable'                      => true,
        'heredoc_to_nowdoc'                             => true,
        'list_syntax'                                   => ['syntax' => 'short'],
        'logical_operators'                             => true,
        'method_argument_space'                         => ['on_multiline' => 'ensure_fully_multiline'],
        'method_chaining_indentation'                   => true,
        'multiline_comment_opening_closing'             => true,
        'no_alternative_syntax'                         => true,
        'no_binary_string'                              => true,
        'no_short_echo_tag'                             => true,
        'no_superfluous_elseif'                         => true,
        'no_unneeded_curly_braces'                      => true,
        'no_unneeded_final_method'                      => true,
        'no_unreachable_default_argument_value'         => true,
        'no_unset_on_property'                          => true,
        'no_useless_else'                               => true,
        'no_useless_return'                             => true,
        'ordered_class_elements'                        => true,
        'ordered_imports'                               => true,
        'php_unit_internal_class'                       => true,
        'php_unit_ordered_covers'                       => true,
        'php_unit_set_up_tear_down_visibility'          => true,
        'php_unit_strict'                               => true,
        'php_unit_test_annotation'                      => true,
        'php_unit_test_case_static_method_calls'        => ['call_type' => 'this'],
        'php_unit_test_class_requires_covers'           => true,
        'phpdoc_add_missing_param_annotation'           => true,
        'phpdoc_order'                                  => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'return_assignment'                             => true,
        'strict_comparison'                             => false,
        'strict_param'                                  => true,
        'string_line_ending'                            => true,
        'yoda_style'                                    => true,
        'binary_operator_spaces'                        => ['operators' => ['=>' => 'align', '=' => 'align'], 'default' => 'single_space'],
        'concat_space'                                  => ['spacing' => 'one'],
    ])
    ->setFinder($finder)
;

return $config;
