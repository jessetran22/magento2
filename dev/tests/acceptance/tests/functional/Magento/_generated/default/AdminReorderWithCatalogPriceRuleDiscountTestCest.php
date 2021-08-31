<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-28642: Reorder doesn't show discount price in Order Totals block")
 * @Description("Reorder doesn't show discount price in Order Totals block<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminReorderWithCatalogPriceRuleDiscountTest.xml<br>")
 * @TestCaseId("MC-28642")
 * @group sales
 * @group catalogRule
 */
class AdminReorderWithCatalogPriceRuleDiscountTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->createEntity("createSimpleProductApi", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProductApi
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogPriceRule
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRuleWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogPriceRule] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogPriceRule
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogPriceRule
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogPriceRule
		$I->comment("Exiting Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPage2
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoaded2
		$I->comment("Create the catalog price rule");
		$I->createEntity("createCatalogRule", "hook", "CatalogRuleToPercent", [], []); // stepKey: createCatalogRule
		$I->comment("Create order via API");
		$I->createEntity("createGuestCart", "hook", "GuestCart", [], []); // stepKey: createGuestCart
		$I->createEntity("addCartItem", "hook", "SimpleCartItem", ["createGuestCart", "createSimpleProductApi"], []); // stepKey: addCartItem
		$I->createEntity("addGuestOrderAddress", "hook", "GuestAddressInformation", ["createGuestCart"], []); // stepKey: addGuestOrderAddress
		$I->updateEntity("createGuestCart", "hook", "GuestOrderPaymentMethod",["createGuestCart"]); // stepKey: sendGuestPaymentInformation
		$I->comment("END Create order via API");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProductApi", "hook"); // stepKey: deleteSimpleProductApi
		$I->comment("Entering Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogPriceRule
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRuleWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogPriceRule] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogPriceRule
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogPriceRule
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogPriceRule
		$I->comment("Exiting Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Sales"})
	 * @Stories({"Admin create order"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReorderWithCatalogPriceRuleDiscountTest(AcceptanceTester $I)
	{
		$I->comment("Open order by Id");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/" . $I->retrieveEntityField('createGuestCart', 'return', 'test')); // stepKey: navigateToOrderPage
		$I->comment("Reorder");
		$I->click("#order_reorder"); // stepKey: clickReorder
		$I->waitForPageLoad(30); // stepKey: clickReorderWaitForPageLoad
		$I->comment("Verify order item row");
		$I->waitForElementVisible(".order-tables  tbody td:nth-child(2) .price", 30); // stepKey: waitOrderItemPriceToBeVisible
		$I->see("110.70", ".order-tables  tbody td:nth-child(2) .price"); // stepKey: seeOrderItemPrice
		$I->comment("Verify totals on Order page");
		$I->scrollTo("//tr[contains(@class,'row-totals')]/td/strong[contains(text(), 'Grand Total')]/parent::td/following-sibling::td//span[contains(@class, 'price')]"); // stepKey: scrollToOrderGrandTotal
		$I->waitForElementVisible("//tr[contains(@class,'row-totals')]/td[contains(text(), 'Subtotal')]/following-sibling::td/span[contains(@class, 'price')]", 30); // stepKey: waitOrderSubtotalToBeVisible
		$I->see("110.70", "//tr[contains(@class,'row-totals')]/td[contains(text(), 'Subtotal')]/following-sibling::td/span[contains(@class, 'price')]"); // stepKey: seeOrderSubTotal
		$I->waitForElementVisible("//tr[contains(@class,'row-totals')]/td[contains(text(), 'Shipping')]/following-sibling::td/span[contains(@class, 'price')]", 30); // stepKey: waitOrderShippingToBeVisible
		$I->see("5.00", "//tr[contains(@class,'row-totals')]/td[contains(text(), 'Shipping')]/following-sibling::td/span[contains(@class, 'price')]"); // stepKey: seeOrderShipping
		$I->waitForElementVisible("//tr[contains(@class,'row-totals')]/td/strong[contains(text(), 'Grand Total')]/parent::td/following-sibling::td//span[contains(@class, 'price')]", 30); // stepKey: waitOrderGrandTotalToBeVisible
		$I->see("115.70", "//tr[contains(@class,'row-totals')]/td/strong[contains(text(), 'Grand Total')]/parent::td/following-sibling::td//span[contains(@class, 'price')]"); // stepKey: seeCorrectGrandTotal
	}
}
