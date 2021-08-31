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
 * @Title("MC-35349: Check pager is working")
 * @Description("Check Pager in order add products grid<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminOrderPagerTest.xml<br>")
 * @TestCaseId("MC-35349")
 * @group sales
 */
class AdminOrderPagerTestCest
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
		$I->comment("21 products created and category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct01", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct01
		$I->createEntity("createProduct02", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct02
		$I->createEntity("createProduct03", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct03
		$I->createEntity("createProduct04", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct04
		$I->createEntity("createProduct05", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct05
		$I->createEntity("createProduct06", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct06
		$I->createEntity("createProduct07", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct07
		$I->createEntity("createProduct08", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct08
		$I->createEntity("createProduct09", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct09
		$I->createEntity("createProduct10", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct10
		$I->createEntity("createProduct11", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct11
		$I->createEntity("createProduct12", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct12
		$I->createEntity("createProduct13", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct13
		$I->createEntity("createProduct14", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct14
		$I->createEntity("createProduct15", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct15
		$I->createEntity("createProduct16", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct16
		$I->createEntity("createProduct17", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct17
		$I->createEntity("createProduct18", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct18
		$I->createEntity("createProduct19", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct19
		$I->createEntity("createProduct20", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct20
		$I->createEntity("createProduct21", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct21
		$I->comment("Customer is created");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Login to Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Delete products");
		$I->deleteEntity("createProduct01", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct02", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createProduct03", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("createProduct04", "hook"); // stepKey: deleteProduct4
		$I->deleteEntity("createProduct05", "hook"); // stepKey: deleteProduct5
		$I->deleteEntity("createProduct06", "hook"); // stepKey: deleteProduct6
		$I->deleteEntity("createProduct07", "hook"); // stepKey: deleteProduct7
		$I->deleteEntity("createProduct08", "hook"); // stepKey: deleteProduct8
		$I->deleteEntity("createProduct09", "hook"); // stepKey: deleteProduct9
		$I->deleteEntity("createProduct10", "hook"); // stepKey: deleteProduct10
		$I->deleteEntity("createProduct11", "hook"); // stepKey: deleteProduct11
		$I->deleteEntity("createProduct12", "hook"); // stepKey: deleteProduct12
		$I->deleteEntity("createProduct13", "hook"); // stepKey: deleteProduct13
		$I->deleteEntity("createProduct14", "hook"); // stepKey: deleteProduct14
		$I->deleteEntity("createProduct15", "hook"); // stepKey: deleteProduct15
		$I->deleteEntity("createProduct16", "hook"); // stepKey: deleteProduct16
		$I->deleteEntity("createProduct17", "hook"); // stepKey: deleteProduct17
		$I->deleteEntity("createProduct18", "hook"); // stepKey: deleteProduct18
		$I->deleteEntity("createProduct19", "hook"); // stepKey: deleteProduct19
		$I->deleteEntity("createProduct20", "hook"); // stepKey: deleteProduct20
		$I->deleteEntity("createProduct21", "hook"); // stepKey: deleteProduct21
		$I->comment("Delete Category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete Customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Admin order pager"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminOrderPagerTest(AcceptanceTester $I)
	{
		$I->comment("Initiate create new order");
		$I->comment("Entering Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductsButtonAppeared
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsButtonAppearedWaitForPageLoad
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProducts
		$I->waitForPageLoad(30); // stepKey: clickAddProductsWaitForPageLoad
		$I->dontSee("div.admin__data-grid-pager > button.action-previous:not(.disabled)"); // stepKey: previousPageDisabled
		$I->waitForPageLoad(30); // stepKey: previousPageDisabledWaitForPageLoad
		$I->click("div.admin__data-grid-pager > button.action-next:not(.disabled)"); // stepKey: clickNextPage
		$I->waitForPageLoad(30); // stepKey: clickNextPageWaitForPageLoad
		$I->seeInField("#sales_order_create_search_grid_page-current", "2"); // stepKey: seeSecondPageOrderGrid
		$I->waitForPageLoad(30); // stepKey: seeSecondPageOrderGridWaitForPageLoad
		$I->click("div.admin__data-grid-pager > button.action-previous:not(.disabled)"); // stepKey: clickPreviousPage
		$I->waitForPageLoad(30); // stepKey: clickPreviousPageWaitForPageLoad
		$I->seeInField("#sales_order_create_search_grid_page-current", "1"); // stepKey: seeFirstPageOrderGrid
		$I->waitForPageLoad(30); // stepKey: seeFirstPageOrderGridWaitForPageLoad
		$I->dontSee("div.admin__data-grid-pager > button.action-previous:not(.disabled)"); // stepKey: prevPageDisabled
		$I->waitForPageLoad(30); // stepKey: prevPageDisabledWaitForPageLoad
	}
}
