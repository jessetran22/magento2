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
 * @Title("MC-39359: Admin should be able to mass update product qty increments")
 * @Description("Admin should be able to mass update product qty increments<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMassUpdateProductQtyIncrementsTest.xml<br>")
 * @TestCaseId("MC-39359")
 * @group catalog
 * @group CatalogInventory
 * @group product_attributes
 */
class AdminMassUpdateProductQtyIncrementsTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProductOne", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProductOne
		$I->createEntity("createProductTwo", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProductTwo
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProductOne", "hook"); // stepKey: deleteProductOne
		$I->deleteEntity("createProductTwo", "hook"); // stepKey: deleteProductTwo
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Mass update advanced inventory attributes"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassUpdateProductQtyIncrementsTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to products list page and select created products");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchByKeywordWaitForPageLoad
		$I->fillField("input#fulltext", "api-simple-product"); // stepKey: fillKeywordSearchFieldSearchByKeyword
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchByKeywordWaitForPageLoad
		$I->comment("Exiting Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->comment("Entering Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->conditionalClick(".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _ascend']/span[text()='ID']", ".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _descend']/span[text()='ID']", false); // stepKey: sortByIdSortProductsByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSortProductsByIdDescending
		$I->comment("Exiting Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckbox1
		$I->click("//*[@id='container']//tr[2]/td[1]//input"); // stepKey: clickCheckbox2
		$I->comment("Mass update qty increments");
		$I->comment("Entering Action Group [clickMassUpdateProductAttributes] AdminClickMassUpdateProductAttributesActionGroup");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownClickMassUpdateProductAttributes
		$I->waitForPageLoad(30); // stepKey: clickDropdownClickMassUpdateProductAttributesWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionClickMassUpdateProductAttributes
		$I->waitForPageLoad(30); // stepKey: clickOptionClickMassUpdateProductAttributesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePageClickMassUpdateProductAttributes
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeInUrlClickMassUpdateProductAttributes
		$I->comment("Exiting Action Group [clickMassUpdateProductAttributes] AdminClickMassUpdateProductAttributesActionGroup");
		$I->comment("Entering Action Group [updateQtyIncrements] AdminMassUpdateProductQtyIncrementsActionGroup");
		$I->click("#attributes_update_tabs_inventory"); // stepKey: openInventoryTabUpdateQtyIncrements
		$I->checkOption("#inventory_enable_qty_increments_checkbox"); // stepKey: changeEnableQtyIncrementsUpdateQtyIncrements
		$I->uncheckOption("#inventory_use_config_enable_qty_increments"); // stepKey: uncheckUseConfigEnableQtyIncrementsUpdateQtyIncrements
		$I->selectOption("#inventory_enable_qty_increments", "Yes"); // stepKey: setEnableQtyIncrementsUpdateQtyIncrements
		$I->checkOption("#inventory_qty_increments_checkbox"); // stepKey: changeQtyIncrementsUpdateQtyIncrements
		$I->uncheckOption("#inventory_use_config_qty_increments"); // stepKey: uncheckUseConfigQtyIncrementsUpdateQtyIncrements
		$I->fillField("#inventory_qty_increments", "2"); // stepKey: setQtyIncrementsUpdateQtyIncrements
		$I->click("button[title='Save']"); // stepKey: saveUpdateQtyIncrements
		$I->waitForPageLoad(30); // stepKey: saveUpdateQtyIncrementsWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitVisibleSuccessMessageUpdateQtyIncrements
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: seeSuccessMessageUpdateQtyIncrements
		$I->comment("Exiting Action Group [updateQtyIncrements] AdminMassUpdateProductQtyIncrementsActionGroup");
		$I->comment("Start message queue for product attribute consumer");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start product_action_attribute.update --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->comment("Open first product for edit and assert that qty increment is updated");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductOne', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->seeOptionIsSelected("//*[@name='product[stock_data][enable_qty_increments]']", "Yes"); // stepKey: assertEnableQtyIncrementsValue
		$I->dontSeeCheckboxIsChecked("//input[@name='product[stock_data][use_config_enable_qty_inc]']"); // stepKey: assertEnableQtyIncrementsUseConfigSettings
		$I->seeInField("//input[@name='product[stock_data][qty_increments]']", "2"); // stepKey: assertQtyIncrementsValue
		$I->dontSeeCheckboxIsChecked("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: assertQtyIncrementsUseConfigSettings
		$I->comment("Open second product for edit and assert that qty increment is updated");
		$I->comment("Entering Action Group [goToProductEditPage2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductTwo', 'id', 'test')); // stepKey: goToProductGoToProductEditPage2
		$I->comment("Exiting Action Group [goToProductEditPage2] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink2] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink2
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink2
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink2
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink2WaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink2] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->seeOptionIsSelected("//*[@name='product[stock_data][enable_qty_increments]']", "Yes"); // stepKey: assertEnableQtyIncrementsValue2
		$I->dontSeeCheckboxIsChecked("//input[@name='product[stock_data][use_config_enable_qty_inc]']"); // stepKey: assertEnableQtyIncrementsUseConfigSettings2
		$I->seeInField("//input[@name='product[stock_data][qty_increments]']", "2"); // stepKey: assertQtyIncrementsValue2
		$I->dontSeeCheckboxIsChecked("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: assertQtyIncrementsUseConfigSettings2
	}
}
