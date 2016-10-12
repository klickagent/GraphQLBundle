<?php

/*
 * This file is part of the OverblogGraphQLPhpGenerator package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\GraphQLGenerator\Tests;

class StarWarsIntrospectionTest extends AbstractStarWarsTest
{
    // Star Wars Introspection Tests
    // Basic Introspection
    // it('Allows querying the schema for types')
    public function testAllowsQueryingTheSchemaForTypes()
    {
        $query = '
        query IntrospectionTypeQuery {
          __schema {
            types {
              name
            }
          }
        }
        ';
        $expected = [
            '__schema' => [
                'types' => [
                    ['name' => 'Query'],
                    ['name' => 'Episode'],
                    ['name' => 'Character'],
                    ['name' => 'String'],
                    ['name' => 'Human'],
                    ['name' => 'Droid'],
                    ['name' => '__Schema'],
                    ['name' => '__Type'],
                    ['name' => '__TypeKind'],
                    ['name' => 'Boolean'],
                    ['name' => '__Field'],
                    ['name' => '__InputValue'],
                    ['name' => '__EnumValue'],
                    ['name' => '__Directive'],
                    ['name' => '__DirectiveLocation'],
                    ['name' => 'ID'],
                    ['name' => 'Float'],
                    ['name' => 'Int'],
                ]
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for query type')
    public function testAllowsQueryingTheSchemaForQueryType()
    {
        $query = '
        query IntrospectionQueryTypeQuery {
          __schema {
            queryType {
              name
            }
          }
        }
        ';
        $expected = [
            '__schema' => [
                'queryType' => [
                    'name' => 'Query'
                ],
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for a specific type')
    public function testAllowsQueryingTheSchemaForASpecificType()
    {
        $query = '
        query IntrospectionDroidTypeQuery {
          __type(name: "Droid") {
            name
          }
        }
        ';
        $expected = [
            '__type' => [
                'name' => 'Droid'
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for an object kind')
    public function testAllowsQueryingForAnObjectKind()
    {
        $query = '
        query IntrospectionDroidKindQuery {
          __type(name: "Droid") {
            name
            kind
          }
        }
        ';
        $expected = [
            '__type' => [
                'name' => 'Droid',
                'kind' => 'OBJECT'
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for an interface kind')
    public function testAllowsQueryingForInterfaceKind()
    {
        $query = '
        query IntrospectionCharacterKindQuery {
          __type(name: "Character") {
            name
            kind
          }
        }
        ';
        $expected = [
            '__type' => [
                'name' => 'Character',
                'kind' => 'INTERFACE'
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for object fields')
    public function testAllowsQueryingForObjectFields()
    {
        $query = '
        query IntrospectionDroidFieldsQuery {
          __type(name: "Droid") {
            name
            fields {
              name
              type {
                name
                kind
              }
            }
          }
        }
        ';
        $expected = [
            '__type' => [
                'name' => 'Droid',
                'fields' => [
                    [
                        'name' => 'id',
                        'type' => [
                            'name' => null,
                            'kind' => 'NON_NULL'
                        ]
                    ],
                    [
                        'name' => 'name',
                        'type' => [
                            'name' => 'String',
                            'kind' => 'SCALAR'
                        ]
                    ],
                    [
                        'name' => 'friends',
                        'type' => [
                            'name' => null,
                            'kind' => 'LIST'
                        ]
                    ],
                    [
                        'name' => 'appearsIn',
                        'type' => [
                            'name' => null,
                            'kind' => 'LIST'
                        ]
                    ],
                    [
                        'name' => 'primaryFunction',
                        'type' => [
                            'name' => 'String',
                            'kind' => 'SCALAR'
                        ]
                    ]
                ]
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for nested object fields')
    public function testAllowsQueryingTheSchemaForNestedObjectFields()
    {
        $query = '
        query IntrospectionDroidNestedFieldsQuery {
          __type(name: "Droid") {
            name
            fields {
              name
              type {
                name
                kind
                ofType {
                  name
                  kind
                }
              }
            }
          }
        }
        ';
        $expected = [
            '__type' => [
                'name' => 'Droid',
                'fields' => [
                    [
                        'name' => 'id',
                        'type' => [
                            'name' => null,
                            'kind' => 'NON_NULL',
                            'ofType' => [
                                'name' => 'String',
                                'kind' => 'SCALAR'
                            ]
                        ]
                    ],
                    [
                        'name' => 'name',
                        'type' => [
                            'name' => 'String',
                            'kind' => 'SCALAR',
                            'ofType' => null
                        ]
                    ],
                    [
                        'name' => 'friends',
                        'type' => [
                            'name' => null,
                            'kind' => 'LIST',
                            'ofType' => [
                                'name' => 'Character',
                                'kind' => 'INTERFACE'
                            ]
                        ]
                    ],
                    [
                        'name' => 'appearsIn',
                        'type' => [
                            'name' => null,
                            'kind' => 'LIST',
                            'ofType' => [
                                'name' => 'Episode',
                                'kind' => 'ENUM'
                            ]
                        ]
                    ],
                    [
                        'name' => 'primaryFunction',
                        'type' => [
                            'name' => 'String',
                            'kind' => 'SCALAR',
                            'ofType' => null
                        ]
                    ]
                ]
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }

    public function testAllowsQueryingTheSchemaForFieldArgs()
    {
        $query = '
        query IntrospectionQueryTypeQuery {
          __schema {
            queryType {
              fields {
                name
                args {
                  name
                  description
                  type {
                    name
                    kind
                    ofType {
                      name
                      kind
                    }
                  }
                  defaultValue
                }
              }
            }
          }
        }
        ';
        $expected = [
            '__schema' => [
                'queryType' => [
                    'fields' => [
                        [
                            'name' => 'hero',
                            'args' => [
                                [
                                    'defaultValue' => null,
                                    'description' => 'If omitted, returns the hero of the whole saga. If provided, returns the hero of that particular episode.',
                                    'name' => 'episode',
                                    'type' => [
                                        'kind' => 'ENUM',
                                        'name' => 'Episode',
                                        'ofType' => null,
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => 'human',
                            'args' => [
                                [
                                    'name' => 'id',
                                    'description' => 'id of the human',
                                    'type' => [
                                        'kind' => 'NON_NULL',
                                        'name' => null,
                                        'ofType' => [
                                            'kind' => 'SCALAR',
                                            'name' => 'String',
                                        ],
                                    ],
                                    'defaultValue' => null,
                                ],
                            ],
                        ],
                        [
                            'name' => 'droid',
                            'args' => [
                                [
                                    'name' => 'id',
                                    'description' => 'id of the droid',
                                    'type' => [
                                        'kind' => 'NON_NULL',
                                        'name' => null,
                                        'ofType' =>
                                            [
                                                'kind' => 'SCALAR',
                                                'name' => 'String',
                                            ],
                                    ],
                                    'defaultValue' => null,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $this->assertValidQuery($query, $expected);
    }

    // it('Allows querying the schema for documentation')
    public function testAllowsQueryingTheSchemaForDocumentation()
    {
        $query = '
        query IntrospectionDroidDescriptionQuery {
          __type(name: "Droid") {
            name
            description
          }
        }
        ';
        $expected = [
            '__type' => [
                'name' => 'Droid',
                'description' => 'A mechanical creature in the Star Wars universe.'
            ]
        ];
        $this->assertValidQuery($query, $expected);
    }
}
