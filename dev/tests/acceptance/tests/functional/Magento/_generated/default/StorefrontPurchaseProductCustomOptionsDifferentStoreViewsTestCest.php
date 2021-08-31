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
 * @Title("MC-16476: Admin should be able to sell products with different variants of their own")
 * @Description("Admin should be able to sell products with different variants of their own<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontPurchaseProductCustomOptionsDifferentStoreViewsTest.xml<br>")
 * @TestCaseId("MC-16476")
 * @group product
 */
class StorefrontPurchaseProductCustomOptionsDifferentStoreViewsTestCest
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
		$I->comment("Create Customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create Simple Product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProductFields['price'] = "100";
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Create storeView 1");
		$I->comment("Entering Action Group [createStoreView1] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView1
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView1
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateStoreView1
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateStoreView1
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView1
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView1
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView1
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView1WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView1
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView1
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView1WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView1
		$I->comment("Exiting Action Group [createStoreView1] AdminCreateStoreViewActionGroup");
		$I->comment("Create storeView 2");
		$I->comment("Entering Action Group [createStoreView2] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView2
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView2
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: enterStoreViewNameCreateStoreView2
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: enterStoreViewCodeCreateStoreView2
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView2
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView2
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView2
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView2WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView2
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView2
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView2WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView2
		$I->comment("Exiting Action Group [createStoreView2] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Customer Log Out");
		$I->comment("Entering Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutStorefront
		$I->comment("Exiting Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete Store View EN");
		$I->comment("Entering Action Group [deleteStoreView1] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView1
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView1WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteStoreView1
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView1WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView1WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView1
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView1WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView1
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView1
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView1
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView1
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView1
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView1
		$I->comment("Exiting Action Group [deleteStoreView1] AdminDeleteStoreViewActionGroup");
		$I->comment("Delete Store View FR");
		$I->comment("Entering Action Group [deleteStoreView2] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView2
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView2WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewFilterFieldDeleteStoreView2
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView2WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView2WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView2
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView2WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView2
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView2
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView2
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView2
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView2
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView2
		$I->comment("Exiting Action Group [deleteStoreView2] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [clearWebsitesGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearWebsitesGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearWebsitesGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearWebsitesGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [clearOrdersGridFilter] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrdersGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrdersGridFilter
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrdersGridFilter
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrdersGridFilter
		$I->comment("Exiting Action Group [clearOrdersGridFilter] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Stories({"Custom options different storeviews"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPurchaseProductCustomOptionsDifferentStoreViewsTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Grid, Filter product and open");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFilterGroupedProductOptions
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFilterGroupedProductOptions
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFilterGroupedProductOptions
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptions
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptionsWaitForPageLoad
		$I->fillField("input[name=sku]", "testSku" . msq("_defaultProduct")); // stepKey: fillSkuFieldOnFiltersSectionFilterGroupedProductOptions
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProductPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProductPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProductPage
		$I->comment("Exiting Action Group [openEditProductPage] OpenEditProductOnBackendActionGroup");
		$I->comment("Update Product with Option Value DropDown 1");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: clickIfContentTabCloses2
		$I->waitForPageLoad(30); // stepKey: clickIfContentTabCloses2WaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: checkAddOption1
		$I->waitForPageLoad(30); // stepKey: checkAddOption1WaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForPageLoad3
		$I->fillField("//span[text()='New Option']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']", "Custom Options 1"); // stepKey: fillOptionTitle1
		$I->click("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//span[text()='Option Type']/parent::label/parent::div/parent::div//div[@data-role='selected-option']"); // stepKey: clickSelect1
		$I->click("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//parent::label/parent::div/parent::div//li[@class='admin__action-multiselect-menu-inner-item']//label[text()='Drop-down']"); // stepKey: clickDropDown1
		$I->click("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tfoot//button"); // stepKey: clickAddValue1
		$I->fillField("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "option1"); // stepKey: fillOptionValueTitle1
		$I->fillField("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "5"); // stepKey: fillOptionValuePrice1
		$I->comment("Update Product with Option Value 1 DropDown 1");
		$I->click("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tfoot//button"); // stepKey: clickAddValue2
		$I->fillField("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "option2"); // stepKey: fillOptionValueTitle2
		$I->fillField("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "50"); // stepKey: fillOptionValuePrice2
		$I->selectOption("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='1']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "percent"); // stepKey: clickSelectPriceType
		$I->comment("Entering Action Group [clickSaveButton1] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton1
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton1
		$I->comment("Exiting Action Group [clickSaveButton1] AdminProductFormSaveActionGroup");
		$I->comment("Switcher to Store FR");
		$I->comment("Entering Action Group [switchToStoreFR] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchToStoreFR
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchToStoreFR
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchToStoreFRWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'FR" . msq("customStoreFR") . "')]"); // stepKey: clickStoreViewByNameSwitchToStoreFR
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchToStoreFRWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchToStoreFR
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchToStoreFRWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchToStoreFR
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchToStoreFRWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchToStoreFR
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchToStoreFR
		$I->see("FR" . msq("customStoreFR"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchToStoreFR
		$I->comment("Exiting Action Group [switchToStoreFR] AdminSwitchStoreViewActionGroup");
		$I->comment("Open tab Customizable Options");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: clickIfContentTabCloses3
		$I->waitForPageLoad(30); // stepKey: clickIfContentTabCloses3WaitForPageLoad
		$I->comment("Update Option Customizable Options and Option Value 1");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad5
		$I->uncheckOption("[data-index='options'] tr.data-row [data-index='title'] [name^='options_use_default']"); // stepKey: uncheckUseDefaultOptionTitle
		$I->fillField("//span[text()='Custom Options 1']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']", "FR Custom Options 1"); // stepKey: fillOptionTitle2
		$I->uncheckOption("[data-index='options'] [data-index='values'] tr[data-repeat-index='0'] [name^='options_use_default']"); // stepKey: uncheckUseDefaultOptionValueTitle1
		$I->fillField("//span[text()='FR Custom Options 1']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "FR option1"); // stepKey: fillOptionValueTitle3
		$I->comment("Update Product with Option Value 1 DropDown 1");
		$I->click("[data-index='options'] [data-index='values'] tr[data-repeat-index='1'] [name^='options_use_default']"); // stepKey: clickHiddenRequireMessage
		$I->uncheckOption("[data-index='options'] [data-index='values'] tr[data-repeat-index='1'] [name^='options_use_default']"); // stepKey: uncheckUseDefaultOptionValueTitle2
		$I->fillField("//span[text()='FR Custom Options 1']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "FR option2"); // stepKey: fillOptionValueTitle4
		$I->comment("Entering Action Group [clickSaveButton2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton2
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButton2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton2
		$I->comment("Exiting Action Group [clickSaveButton2] AdminProductFormSaveActionGroup");
		$I->comment("Login Customer Storefront");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Go to Product Page");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct1Page
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->seeElement("//label[contains(.,'Custom Options 1')]"); // stepKey: seeProductOptionDropDownTitle
		$I->seeElement("//label[contains(.,'Custom Options 1')]/../div[@class='control']//select//option[contains(.,'option1')]"); // stepKey: seeproductOptionDropDownOptionTitle1
		$I->seeElement("//label[contains(.,'Custom Options 1')]/../div[@class='control']//select//option[contains(.,'option2')]"); // stepKey: seeproductOptionDropDownOptionTitle2
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'Custom Options 1')]/../div[@class='control']//select", "5"); // stepKey: selectProductOptionDropDown
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage1] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage1
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage1
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage1
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage1] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'Custom Options 1')]/../div[@class='control']//select", "50"); // stepKey: selectProductOptionDropDown1
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Checking the correctness of displayed custom options for user parameters on checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->conditionalClick("div.block.items-in-cart", "div.block.items-in-cart", true); // stepKey: exposeMiniCart
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForCartItem
		$I->waitForElement("div.block.items-in-cart.active", 30); // stepKey: waitForCartItemsAreaActive
		$I->waitForPageLoad(30); // stepKey: waitForCartItemsAreaActiveWaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "ol.minicart-items"); // stepKey: seeProductInCart
		$I->comment("See Custom options are displayed as option1");
		$I->conditionalClick("//div[@class='product-item-inner']//div[@class='subtotal']//span[@class='price'][contains(.,'105')]//ancestor::div[@class='product-item-details']//div[@class='product options']", "//div[@class='subtotal']//span[@class='price'][contains(.,'105')]//ancestor::div[@class='product-item-details']//div[@class='product options active']", false); // stepKey: exposeProductOptions
		$I->see("option1", "//div[@class='subtotal']//span[@class='price'][contains(.,'105')]//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionValueDropdown1Input1
		$I->comment("See Custom options are displayed as option2");
		$I->conditionalClick("//div[@class='product-item-inner']//div[@class='subtotal']//span[@class='price'][contains(.,'150')]//ancestor::div[@class='product-item-details']//div[@class='product options']", "//div[@class='subtotal']//span[@class='price'][contains(.,'150')]//ancestor::div[@class='product-item-details']//div[@class='product options active']", false); // stepKey: exposeProductOptions1
		$I->see("option2", "//div[@class='subtotal']//span[@class='price'][contains(.,'150')]//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionValueDropdown1Input2
		$I->comment("Place Order");
		$I->comment("Select shipping method");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Select payment method");
		$I->comment("Entering Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethod
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethod
		$I->comment("Exiting Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Place Order");
		$I->comment("Entering Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberCustomerPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouCustomerPlaceOrder
		$I->comment("Exiting Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Open Order");
		$I->comment("Entering Action Group [openOrdersGrid] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrdersGrid
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrdersGrid
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrdersGrid
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrdersGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrdersGrid
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrdersGrid
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrdersGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrdersGrid
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterOpenOrdersGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrdersGrid
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrdersGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrdersGrid
		$I->comment("Exiting Action Group [openOrdersGrid] FilterOrderGridByIdActionGroup");
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Checking the correctness of displayed custom options for user parameters on Order");
		$I->see("option1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueDropdown1
		$I->see("option2", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueDropdown2
		$I->comment("Switch to FR Store View Storefront");
		$I->comment("Entering Action Group [amOnProduct4Page] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnProduct4Page
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnProduct4Page
		$I->comment("Exiting Action Group [amOnProduct4Page] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [switchStore] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStore
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStore
		$I->click("li.view-fr" . msq("customStoreFR") . ">a"); // stepKey: clickSelectStoreViewSwitchStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStore
		$I->comment("Exiting Action Group [switchStore] StorefrontSwitchStoreViewActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct2Page
		$I->seeElement("//label[contains(.,'FR Custom Options 1')]"); // stepKey: seeProductFrOptionDropDownTitle
		$I->seeElement("//label[contains(.,'FR Custom Options 1')]/../div[@class='control']//select//option[contains(.,'FR option1')]"); // stepKey: productFrOptionDropDownOptionTitle1
		$I->seeElement("//label[contains(.,'FR Custom Options 1')]/../div[@class='control']//select//option[contains(.,'FR option2')]"); // stepKey: productFrOptionDropDownOptionTitle2
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'FR Custom Options 1')]/../div[@class='control']//select", "5"); // stepKey: seeProductFrOptionDropDown
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage2] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage2
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage2] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'FR Custom Options 1')]/../div[@class='control']//select", "50"); // stepKey: seeProductFrOptionDropDown1
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage3] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage3
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage3
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage3
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage3
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage3] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Checking the correctness of displayed custom options for user parameters on checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart1] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart1
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart1
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart1
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicart1WaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart1
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicart1WaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart1] GoToCheckoutFromMinicartActionGroup");
		$I->conditionalClick("div.block.items-in-cart", "div.block.items-in-cart", true); // stepKey: exposeMiniCart1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForCartItem1
		$I->waitForElement("div.block.items-in-cart.active", 30); // stepKey: waitForCartItemsAreaActive1
		$I->waitForPageLoad(30); // stepKey: waitForCartItemsAreaActive1WaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "ol.minicart-items"); // stepKey: seeProductInCar1t
		$I->comment("See Custom options are displayed as option1");
		$I->conditionalClick("//div[@class='product-item-inner']//div[@class='subtotal']//span[@class='price'][contains(.,'105')]//ancestor::div[@class='product-item-details']//div[@class='product options']", "//div[@class='subtotal']//span[@class='price'][contains(.,'105')]//ancestor::div[@class='product-item-details']//div[@class='product options active']", false); // stepKey: exposeProductOptions2
		$I->see("FR option1", "//div[@class='subtotal']//span[@class='price'][contains(.,'105')]//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductFrOptionValueDropdown1Input2
		$I->comment("See Custom options are displayed as option2");
		$I->conditionalClick("//div[@class='product-item-inner']//div[@class='subtotal']//span[@class='price'][contains(.,'150')]//ancestor::div[@class='product-item-details']//div[@class='product options']", "//div[@class='subtotal']//span[@class='price'][contains(.,'150')]//ancestor::div[@class='product-item-details']//div[@class='product options active']", false); // stepKey: exposeProductOptions3
		$I->see("FR option2", "//div[@class='subtotal']//span[@class='price'][contains(.,'150')]//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductFrOptionValueDropdown1Input3
		$I->comment("Place Order");
		$I->comment("Select shipping method");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod2] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod2
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod2] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [clickNext2] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext2
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNext2WaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNext2
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNext2WaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext2
		$I->waitForPageLoad(30); // stepKey: clickNextClickNext2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNext2
		$I->comment("Exiting Action Group [clickNext2] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Select payment method");
		$I->comment("Entering Action Group [selectPaymentMethod2] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethod2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethod2
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethod2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethod2
		$I->comment("Exiting Action Group [selectPaymentMethod2] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Place Order");
		$I->comment("Entering Action Group [customerPlaceOrder2] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder2
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder2WaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceOrder2
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceOrder2WaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberCustomerPlaceOrder2
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouCustomerPlaceOrder2
		$I->comment("Exiting Action Group [customerPlaceOrder2] CheckoutPlaceOrderActionGroup");
		$I->comment("Open Product Grid, Filter product and open");
		$I->comment("Entering Action Group [amOnProductGridPage1] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage1
		$I->comment("Exiting Action Group [amOnProductGridPage1] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterGroupedProductOptions1] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFilterGroupedProductOptions1
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFilterGroupedProductOptions1
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFilterGroupedProductOptions1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptions1
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptions1WaitForPageLoad
		$I->fillField("input[name=sku]", "testSku" . msq("_defaultProduct")); // stepKey: fillSkuFieldOnFiltersSectionFilterGroupedProductOptions1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptions1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptions1WaitForPageLoad
		$I->comment("Exiting Action Group [filterGroupedProductOptions1] SearchForProductOnBackendActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEdit1
		$I->waitForPageLoad(30); // stepKey: openProductForEdit1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad16
		$I->comment("Switcher to Store FR");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage2
		$I->click("#store-change-button"); // stepKey: clickStoreSwitcher1
		$I->waitForPageLoad(10); // stepKey: clickStoreSwitcher1WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='FR" . msq("customStoreFR") . "']"); // stepKey: clickStoreView1
		$I->waitForPageLoad(10); // stepKey: clickStoreView1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptMessage1
		$I->waitForPageLoad(60); // stepKey: acceptMessage1WaitForPageLoad
		$I->comment("Open tab Customizable Options");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad17
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: clickIfContentTabCloses4
		$I->waitForPageLoad(30); // stepKey: clickIfContentTabCloses4WaitForPageLoad
		$I->comment("Update Option Customizable Options and Option Value 1");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad18
		$I->checkOption("[data-index='options'] tr.data-row [data-index='title'] [name^='options_use_default']"); // stepKey: checkUseDefaultOptionTitle
		$I->checkOption("[data-index='options'] [data-index='values'] tr[data-repeat-index='0'] [name^='options_use_default']"); // stepKey: checkUseDefaultOptionValueTitle1
		$I->comment("Update Product with Option Value 1 DropDown 1");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad19
		$I->checkOption("[data-index='options'] [data-index='values'] tr[data-repeat-index='1'] [name^='options_use_default']"); // stepKey: checkUseDefaultOptionValueTitle2
		$I->comment("Entering Action Group [clickSaveButton3] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton3
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButton3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton3
		$I->comment("Exiting Action Group [clickSaveButton3] AdminProductFormSaveActionGroup");
		$I->comment("Go to Product Page");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct2Page2
		$I->seeElement("//label[contains(.,'Custom Options 1')]"); // stepKey: seeProductOptionDropDownTitle1
		$I->seeElement("//label[contains(.,'Custom Options 1')]/../div[@class='control']//select//option[contains(.,'option1')]"); // stepKey: seeProductOptionDropDownOptionTitle3
		$I->seeElement("//label[contains(.,'Custom Options 1')]/../div[@class='control']//select//option[contains(.,'option2')]"); // stepKey: seeProductOptionDropDownOptionTitle4
	}
}
