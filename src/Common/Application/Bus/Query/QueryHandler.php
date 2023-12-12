<?php

declare(strict_types=1);

namespace Common\Application\Bus\Query;

/**
 * The QueryHandler interface defines a contract for a query handler.
 * A query handler is responsible for handling queries dispatched by the query bus.
 * It does not define any methods, and serves as a marker interface.
 * Each query should have exactly one corresponding query handler.
 */
interface QueryHandler {}