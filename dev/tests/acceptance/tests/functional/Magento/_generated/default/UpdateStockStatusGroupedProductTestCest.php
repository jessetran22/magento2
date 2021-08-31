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
 * @Title("MC-38057: Stock status of grouped product after changing quantity of child product should be changed")
 * @Description("Change stock of grouped product after changing quantity of child product<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/UpdateStockStatusGroupedProductTest.xml<br>")
 * @TestCaseId("MC-38057")
 * @group GroupedProduct
 */
class UpdateStockStatusGroupedProductTestCest
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
		$I->comment("Create simple and grouped product");
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct", [], []); // stepKey: createGroupedProduct
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createFirstSimpleProduct"], []); // stepKey: addProductOne
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
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
		$I->comment("Delete created data");
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"Create/Edit grouped product in Admin"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function UpdateStockStatusGroupedProductTest(AcceptanceTester $I)
	{
		$I->comment("1.Open product grid page and choose \"Update attributes\" and set product stock status to \"Out of Stock\"");
		$I->comment("Entering Action Group [setProductToOutOfStock] AdminMassUpdateProductQtyAndStockStatusActionGroup");
		$I->comment("Filter product in product grid");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFirstTimeSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: waitForProductGridPageLoadSetProductToOutOfStock
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSetProductToOutOfStockWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersSetProductToOutOfStock
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test')); // stepKey: fillProductNameFilterSetProductToOutOfStock
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterSetProductToOutOfStock
		$I->selectOption("select.admin__control-select[name='type_id']", $I->retrieveEntityField('createFirstSimpleProduct', 'type_id', 'test')); // stepKey: selectionProductTypeSetProductToOutOfStock
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersSetProductToOutOfStockWaitForPageLoad
		$I->comment("Select first product from grid and open mass action");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckboxSetProductToOutOfStock
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: clickDropdownSetProductToOutOfStockWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: clickOptionSetProductToOutOfStockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForUploadPageSetProductToOutOfStock
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeAttributePageEditUrlSetProductToOutOfStock
		$I->comment("Update inventory attributes and save");
		$I->click("#attributes_update_tabs_inventory"); // stepKey: openInvetoryTabSetProductToOutOfStock
		$I->click("#inventory_qty_checkbox"); // stepKey: uncheckChangeQtySetProductToOutOfStock
		$I->fillField("#inventory_qty", "0"); // stepKey: fillFieldNameSetProductToOutOfStock
		$I->click("#inventory_stock_availability_checkbox"); // stepKey: uncheckChangeStockAvailabilitySetProductToOutOfStock
		$I->selectOption("//select[@name='inventory[is_in_stock]']", "Out of Stock"); // stepKey: selectStatusSetProductToOutOfStock
		$I->click("button[title='Save']"); // stepKey: saveSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: saveSetProductToOutOfStockWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitVisibleSuccessMessageSetProductToOutOfStock
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: seeSuccessMessageSetProductToOutOfStock
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageSecondTimeSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: waitForProductGridPageSetProductToOutOfStock
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAfterMassActionSetProductToOutOfStock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAfterMassActionSetProductToOutOfStockWaitForPageLoad
		$I->comment("Exiting Action Group [setProductToOutOfStock] AdminMassUpdateProductQtyAndStockStatusActionGroup");
		$I->comment("2.Run cron for updating stock status of parent product");
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("3.Check stock status of grouped product. Stock status should be \"Out of Stock\"");
		$I->comment("Entering Action Group [checkProductOutOfStock] AssertAdminProductStockStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createGroupedProduct', 'id', 'test')); // stepKey: goToProductEditPageCheckProductOutOfStock
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductOutOfStock
		$I->seeOptionIsSelected("select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: checkProductStatusCheckProductOutOfStock
		$I->waitForPageLoad(30); // stepKey: checkProductStatusCheckProductOutOfStockWaitForPageLoad
		$I->comment("Exiting Action Group [checkProductOutOfStock] AssertAdminProductStockStatusActionGroup");
		$I->comment("4.Open product grid page choose \"Update attributes\" and set product stock status to \"In Stock\"");
		$I->comment("Entering Action Group [returnProductToInStock] AdminMassUpdateProductQtyAndStockStatusActionGroup");
		$I->comment("Filter product in product grid");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFirstTimeReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: waitForProductGridPageLoadReturnProductToInStock
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialReturnProductToInStockWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersReturnProductToInStock
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test')); // stepKey: fillProductNameFilterReturnProductToInStock
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterReturnProductToInStock
		$I->selectOption("select.admin__control-select[name='type_id']", $I->retrieveEntityField('createFirstSimpleProduct', 'type_id', 'test')); // stepKey: selectionProductTypeReturnProductToInStock
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersReturnProductToInStockWaitForPageLoad
		$I->comment("Select first product from grid and open mass action");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckboxReturnProductToInStock
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: clickDropdownReturnProductToInStockWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: clickOptionReturnProductToInStockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForUploadPageReturnProductToInStock
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeAttributePageEditUrlReturnProductToInStock
		$I->comment("Update inventory attributes and save");
		$I->click("#attributes_update_tabs_inventory"); // stepKey: openInvetoryTabReturnProductToInStock
		$I->click("#inventory_qty_checkbox"); // stepKey: uncheckChangeQtyReturnProductToInStock
		$I->fillField("#inventory_qty", "10"); // stepKey: fillFieldNameReturnProductToInStock
		$I->click("#inventory_stock_availability_checkbox"); // stepKey: uncheckChangeStockAvailabilityReturnProductToInStock
		$I->selectOption("//select[@name='inventory[is_in_stock]']", "In Stock"); // stepKey: selectStatusReturnProductToInStock
		$I->click("button[title='Save']"); // stepKey: saveReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: saveReturnProductToInStockWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitVisibleSuccessMessageReturnProductToInStock
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: seeSuccessMessageReturnProductToInStock
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageSecondTimeReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: waitForProductGridPageReturnProductToInStock
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAfterMassActionReturnProductToInStock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAfterMassActionReturnProductToInStockWaitForPageLoad
		$I->comment("Exiting Action Group [returnProductToInStock] AdminMassUpdateProductQtyAndStockStatusActionGroup");
		$I->comment("5.Check stock status of grouped product. Stock status should be \"In Stock\"");
		$I->comment("Entering Action Group [checkProductInStock] AssertAdminProductStockStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createGroupedProduct', 'id', 'test')); // stepKey: goToProductEditPageCheckProductInStock
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductInStock
		$I->seeOptionIsSelected("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: checkProductStatusCheckProductInStock
		$I->waitForPageLoad(30); // stepKey: checkProductStatusCheckProductInStockWaitForPageLoad
		$I->comment("Exiting Action Group [checkProductInStock] AssertAdminProductStockStatusActionGroup");
	}
}
