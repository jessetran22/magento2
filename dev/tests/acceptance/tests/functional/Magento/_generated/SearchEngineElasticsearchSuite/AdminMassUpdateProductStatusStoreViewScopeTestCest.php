<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-28538: Admin should be able to mass update product statuses in store view scope")
 * @Description("Admin should be able to mass update product statuses in store view scope<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMassUpdateProductStatusStoreViewScopeTest/AdminMassUpdateProductStatusStoreViewScopeTest.xml<br>")
 * @TestCaseId("MC-28538")
 * @group Catalog
 * @group Product Attributes
 * @group SearchEngineElasticsearch
 */
class AdminMassUpdateProductStatusStoreViewScopeTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
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
		$I->comment("Entering Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateAdditionalWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateAdditionalWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateAdditionalWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateAdditionalWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateAdditionalWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateAdditionalWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateAdditionalWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateAdditionalWebsite
		$I->comment("Exiting Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateNewStoreView
		$I->comment("Exiting Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Create a Simple Product 1");
		$I->comment("Entering Action Group [createSimpleProduct1] CreateSimpleProductAndAddToWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToCatalogProductGridCreateSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductGridCreateSimpleProduct1
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateSimpleProduct1WaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddSimpleProductCreateSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: clickAddSimpleProductCreateSimpleProduct1WaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "massUpdateProductName" . msq("simpleProductForMassUpdate")); // stepKey: fillProductNameCreateSimpleProduct1
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("simpleProductForMassUpdate")); // stepKey: fillProductSKUCreateSimpleProduct1
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceCreateSimpleProduct1
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQuantityCreateSimpleProduct1
		$I->click("div[data-index='websites']"); // stepKey: openProductInWebsitesCreateSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: openProductInWebsitesCreateSimpleProduct1WaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteCreateSimpleProduct1
		$I->click("#save-button"); // stepKey: clickSaveCreateSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveCreateSimpleProduct1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForProductPageSaveCreateSimpleProduct1
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageCreateSimpleProduct1
		$I->comment("Exiting Action Group [createSimpleProduct1] CreateSimpleProductAndAddToWebsiteActionGroup");
		$I->comment("Create a Simple Product 2");
		$I->comment("Entering Action Group [createSimpleProduct2] CreateSimpleProductAndAddToWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToCatalogProductGridCreateSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductGridCreateSimpleProduct2
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateSimpleProduct2WaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddSimpleProductCreateSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickAddSimpleProductCreateSimpleProduct2WaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "massUpdateProductName" . msq("simpleProductForMassUpdate2")); // stepKey: fillProductNameCreateSimpleProduct2
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("simpleProductForMassUpdate2")); // stepKey: fillProductSKUCreateSimpleProduct2
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceCreateSimpleProduct2
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQuantityCreateSimpleProduct2
		$I->click("div[data-index='websites']"); // stepKey: openProductInWebsitesCreateSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: openProductInWebsitesCreateSimpleProduct2WaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteCreateSimpleProduct2
		$I->click("#save-button"); // stepKey: clickSaveCreateSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveCreateSimpleProduct2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForProductPageSaveCreateSimpleProduct2
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageCreateSimpleProduct2
		$I->comment("Exiting Action Group [createSimpleProduct2] CreateSimpleProductAndAddToWebsiteActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete website");
		$I->comment("Entering Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteSecondWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSecondWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteSecondWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteSecondWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteSecondWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteSecondWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->comment("Delete Products");
		$I->comment("Entering Action Group [deleteProduct1] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct1
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("simpleProductForMassUpdate")); // stepKey: fillProductSkuFilterDeleteProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProduct1WaitForPageLoad
		$I->see("testSku" . msq("simpleProductForMassUpdate"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct1
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct1
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct1
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProduct1WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProduct1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProduct1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProduct1WaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct1
		$I->comment("Exiting Action Group [deleteProduct1] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteProduct2] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct2
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct2
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("simpleProductForMassUpdate2")); // stepKey: fillProductSkuFilterDeleteProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProduct2WaitForPageLoad
		$I->see("testSku" . msq("simpleProductForMassUpdate2"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct2
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct2
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct2
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProduct2WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProduct2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct2
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProduct2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct2
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProduct2WaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct2
		$I->comment("Exiting Action Group [deleteProduct2] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Mass update product status"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassUpdateProductStatusStoreViewScopeTest(AcceptanceTester $I)
	{
		$I->comment("Search and select products");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchByKeywordWaitForPageLoad
		$I->fillField("input#fulltext", "massUpdateProductName"); // stepKey: fillKeywordSearchFieldSearchByKeyword
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchByKeywordWaitForPageLoad
		$I->comment("Exiting Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->comment("Entering Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->conditionalClick(".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _ascend']/span[text()='ID']", ".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _descend']/span[text()='ID']", false); // stepKey: sortByIdSortProductsByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSortProductsByIdDescending
		$I->comment("Exiting Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->comment("Filter to Second Store View");
		$I->comment("Entering Action Group [filterStoreView] AdminFilterStoreViewActionGroup");
		$I->click("//div[@class='data-grid-filters-action-wrap']/button"); // stepKey: ClickOnFilterFilterStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnFilterFilterStoreViewWaitForPageLoad
		$I->click("//select[@name='store_id']"); // stepKey: ClickOnStoreViewDropDownFilterStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnStoreViewDropDownFilterStoreViewWaitForPageLoad
		$I->click("//select[@name='store_id']/option[contains(text(),'store" . msq("customStore") . "')]"); // stepKey: ClickOnStoreViewOptionFilterStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnStoreViewOptionFilterStoreViewWaitForPageLoad
		$I->click("//button[@class='action-secondary']"); // stepKey: ClickOnApplyFiltersFilterStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnApplyFiltersFilterStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [filterStoreView] AdminFilterStoreViewActionGroup");
		$I->comment("Select Product 2");
		$I->click("//*[@id='container']//tr[2]/td[1]//input"); // stepKey: clickCheckbox2
		$I->comment("Mass update attributes");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdown
		$I->waitForPageLoad(30); // stepKey: clickDropdownWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickOption
		$I->waitForPageLoad(30); // stepKey: clickOptionWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Disable']"); // stepKey: clickDisabled
		$I->waitForPageLoad(30); // stepKey: clickDisabledWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePage
		$I->comment("Verify Product Statuses");
		$I->see("Enabled", "//*[@id='container']//tr[1]/td"); // stepKey: checkIfProduct1IsEnabled
		$I->see("Disabled", "//*[@id='container']//tr[2]/td"); // stepKey: checkIfProduct2IsDisabled
		$I->comment("Filter to Default Store View");
		$I->comment("Entering Action Group [filterDefaultStoreView] AdminFilterStoreViewActionGroup");
		$I->click("//div[@class='data-grid-filters-action-wrap']/button"); // stepKey: ClickOnFilterFilterDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnFilterFilterDefaultStoreViewWaitForPageLoad
		$I->click("//select[@name='store_id']"); // stepKey: ClickOnStoreViewDropDownFilterDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnStoreViewDropDownFilterDefaultStoreViewWaitForPageLoad
		$I->click("//select[@name='store_id']/option[contains(text(),'Default')]"); // stepKey: ClickOnStoreViewOptionFilterDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnStoreViewOptionFilterDefaultStoreViewWaitForPageLoad
		$I->click("//button[@class='action-secondary']"); // stepKey: ClickOnApplyFiltersFilterDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: ClickOnApplyFiltersFilterDefaultStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [filterDefaultStoreView] AdminFilterStoreViewActionGroup");
		$I->comment("Verify Product Statuses");
		$I->see("Enabled", "//*[@id='container']//tr[1]/td"); // stepKey: checkIfDefaultViewProduct1IsEnabled
		$I->see("Enabled", "//*[@id='container']//tr[2]/td"); // stepKey: checkIfDefaultViewProduct2IsEnabled
		$I->comment("Assert on storefront default view with first product");
		$I->comment("Entering Action Group [GoToStoreViewAdvancedCatalogSearchActionGroupDefault] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStoreViewAdvancedCatalogSearchActionGroupDefault
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStoreViewAdvancedCatalogSearchActionGroupDefault
		$I->comment("Exiting Action Group [GoToStoreViewAdvancedCatalogSearchActionGroupDefault] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->comment("Entering Action Group [searchByNameDefault] StorefrontAdvancedCatalogSearchByProductNameAndDescriptionActionGroup");
		$I->fillField("#name", "massUpdateProductName" . msq("simpleProductForMassUpdate")); // stepKey: fillNameSearchByNameDefault
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchByNameDefault
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchByNameDefault
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchByNameDefault
		$I->comment("Exiting Action Group [searchByNameDefault] StorefrontAdvancedCatalogSearchByProductNameAndDescriptionActionGroup");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResultDefault] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultDefault
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultDefault
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultDefault
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResultDefault] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("1 item", ".search.found>strong"); // stepKey: seeInDefault
		$I->comment("Assert on storefront default view with second product");
		$I->comment("Entering Action Group [GoToStoreViewAdvancedCatalogSearchActionGroupDefaultToSearchSecondProduct] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStoreViewAdvancedCatalogSearchActionGroupDefaultToSearchSecondProduct
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStoreViewAdvancedCatalogSearchActionGroupDefaultToSearchSecondProduct
		$I->comment("Exiting Action Group [GoToStoreViewAdvancedCatalogSearchActionGroupDefaultToSearchSecondProduct] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->comment("Entering Action Group [searchByNameDefaultWithSecondProduct] StorefrontAdvancedCatalogSearchByProductNameAndDescriptionActionGroup");
		$I->fillField("#name", "massUpdateProductName" . msq("simpleProductForMassUpdate2")); // stepKey: fillNameSearchByNameDefaultWithSecondProduct
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchByNameDefaultWithSecondProduct
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchByNameDefaultWithSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchByNameDefaultWithSecondProduct
		$I->comment("Exiting Action Group [searchByNameDefaultWithSecondProduct] StorefrontAdvancedCatalogSearchByProductNameAndDescriptionActionGroup");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResultDefaultForSecondProduct] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultDefaultForSecondProduct
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultDefaultForSecondProduct
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultDefaultForSecondProduct
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResultDefaultForSecondProduct] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("1 item", ".search.found>strong"); // stepKey: seeInDefaultSecondProductResults
		$I->comment("Enable the product in Default store view");
		$I->comment("Entering Action Group [navigateToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex2
		$I->comment("Exiting Action Group [navigateToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckboxDefaultStoreView
		$I->click("//*[@id='container']//tr[2]/td[1]//input"); // stepKey: clickCheckboxDefaultStoreView2
		$I->comment("Mass update attributes");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickDropdownDefaultStoreViewWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickOptionDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickOptionDefaultStoreViewWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Disable']"); // stepKey: clickDisabledDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickDisabledDefaultStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePageDefaultStoreView
		$I->see("Disabled", "//*[@id='container']//tr[1]/td"); // stepKey: checkIfProduct2IsDisabledDefaultStoreView
		$I->comment("Assert on storefront default view");
		$I->comment("Entering Action Group [GoToStoreViewAdvancedCatalogSearchActionGroupDefault2] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStoreViewAdvancedCatalogSearchActionGroupDefault2
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStoreViewAdvancedCatalogSearchActionGroupDefault2
		$I->comment("Exiting Action Group [GoToStoreViewAdvancedCatalogSearchActionGroupDefault2] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->comment("Entering Action Group [searchByNameDefault2] StorefrontAdvancedCatalogSearchByProductNameAndDescriptionActionGroup");
		$I->fillField("#name", "massUpdateProductName" . msq("simpleProductForMassUpdate")); // stepKey: fillNameSearchByNameDefault2
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchByNameDefault2
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchByNameDefault2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchByNameDefault2
		$I->comment("Exiting Action Group [searchByNameDefault2] StorefrontAdvancedCatalogSearchByProductNameAndDescriptionActionGroup");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResultDefault2] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultDefault2
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultDefault2
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultDefault2
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResultDefault2] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("We can't find any items matching these search criteria.", "div.message div"); // stepKey: seeInDefault2
	}
}
