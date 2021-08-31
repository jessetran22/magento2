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
 * @Title("MC-5359: Create product with several websites and check URL Rewrites")
 * @Description("Test log in to Create product and Create product with several websites and check URL Rewrites<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCreateProductWithSeveralWebsitesAndCheckURLRewritesTest.xml<br>")
 * @TestCaseId("MC-5359")
 * @group urlRewrite
 * @group mtf_migrated
 */
class AdminCreateProductWithSeveralWebsitesAndCheckURLRewritesTestCest
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
		$I->createEntity("rootCategory", "hook", "NewRootCategory", [], []); // stepKey: rootCategory
		$I->createEntity("category", "hook", "SimpleRootSubCategory", ["rootCategory"], []); // stepKey: category
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: createProduct
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
		$I->comment("Entering Action Group [deleteStore1] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteStore1
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStore1
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStore1WaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteStore1
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteStore1
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteStore1WaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteStore1
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteStore1
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteStore1
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStore1
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStore1WaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteStore1
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStore1
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStore1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteStore1
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteStore1
		$I->comment("Exiting Action Group [deleteStore1] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [deleteStore2] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteStore2
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStore2
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStore2WaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldDeleteStore2
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteStore2
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteStore2WaitForPageLoad
		$I->see("store" . msq("customStoreGroup"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteStore2
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteStore2
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteStore2
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStore2
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStore2WaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteStore2
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStore2
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStore2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteStore2
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteStore2
		$I->comment("Exiting Action Group [deleteStore2] DeleteCustomStoreActionGroup");
		$I->deleteEntity("rootCategory", "hook"); // stepKey: deleteRootCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Create product with several websites"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductWithSeveralWebsitesAndCheckURLRewritesTest(AcceptanceTester $I)
	{
		$I->comment("Create first store");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create first store view");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateNewStoreView
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
		$I->comment("Create second store");
		$I->comment("Entering Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStore
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreWaitForPageLoad
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectMainWebsiteCreateCustomStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameCreateCustomStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeCreateCustomStore
		$I->selectOption("#group_root_category_id", $I->retrieveEntityField('rootCategory', 'name', 'test')); // stepKey: selectStoreStatusCreateCustomStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStore
		$I->comment("Exiting Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->comment("Create second store view");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Create simple product with categories created in create data");
		$I->comment("Entering Action Group [openProductsGrid] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductsGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductsGrid
		$I->comment("Exiting Action Group [openProductsGrid] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProduct] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProduct
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProductWaitForPageLoad
		$I->comment("Exiting Action Group [openProduct] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Entering Action Group [unselectInitialCategory] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('rootCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryUnselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryUnselectInitialCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [unselectInitialCategory] SetCategoryByNameActionGroup");
		$I->comment("Entering Action Group [pressDoneButton] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonPressDoneButton
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonPressDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyPressDoneButton
		$I->comment("Exiting Action Group [pressDoneButton] AdminSubmitCategoriesPopupActionGroup");
		$I->comment("Entering Action Group [setNewCategory] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('category', 'name', 'test')]); // stepKey: searchAndSelectCategorySetNewCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategorySetNewCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [setNewCategory] SetCategoryByNameActionGroup");
		$I->comment("Entering Action Group [clickOnDoneButton] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneButton
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneButton
		$I->comment("Exiting Action Group [clickOnDoneButton] AdminSubmitCategoriesPopupActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormNoSuccessCheckActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormNoSuccessCheckActionGroup");
		$I->comment("Verify customer see success message");
		$I->comment("Entering Action Group [seeAssertSimpleProductSaveSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeAssertSimpleProductSaveSuccessMessage
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: verifyMessageSeeAssertSimpleProductSaveSuccessMessage
		$I->comment("Exiting Action Group [seeAssertSimpleProductSaveSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Grab category Id");
		$I->comment("Entering Action Group [grabCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGrabCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGrabCategoryId
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeGrabCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadGrabCategoryId
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category', 'name', 'test') . "')]"); // stepKey: selectCategoryGrabCategoryId
		$I->waitForPageLoad(30); // stepKey: selectCategoryGrabCategoryIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGrabCategoryId
		$I->waitForElementVisible("h1.page-title", 30); // stepKey: waitForCategoryTitleGrabCategoryId
		$I->comment("Exiting Action Group [grabCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Open Url Rewrite page and verify new Redirect Path, RedirectType and Target Path for the grabbed category Id");
		$I->comment("Entering Action Group [searchPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('category', 'name', 'test') . ".html"); // stepKey: fillRedirectPathFilterSearchPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchPath
		$I->see($I->retrieveEntityField('category', 'name', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchPath
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchPath
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchPath
		$I->comment("Exiting Action Group [searchPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeStoreValueForCategoryId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->see("store" . msq("customStoreGroup"), "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Store View')]/preceding-sibling::th)+1]"); // stepKey: seeStoreValueForCategoryIdSeeStoreValueForCategoryId
		$I->comment("Exiting Action Group [seeStoreValueForCategoryId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->comment("Entering Action Group [seeStoreViewValueForCategoryId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->see("EN" . msq("customStoreEN"), "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Store View')]/preceding-sibling::th)+1]"); // stepKey: seeStoreValueForCategoryIdSeeStoreViewValueForCategoryId
		$I->comment("Exiting Action Group [seeStoreViewValueForCategoryId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->comment("Grab product Id");
		$I->comment("Entering Action Group [grabProductId] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageGrabProductId
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGrabProductId
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGrabProductId
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGrabProductIdWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGrabProductId
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterGrabProductId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGrabProductId
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGrabProductIdWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadGrabProductId
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductGrabProductId
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadGrabProductId
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleGrabProductId
		$I->comment("Exiting Action Group [grabProductId] FilterAndSelectProductActionGroup");
		$productId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: productId
		$I->comment("Open Url Rewrite page and verify new Redirect Path, RedirectType and Target Path for the grabbed product Id");
		$I->comment("Entering Action Group [searchPath1] AdminFilterUrlRewriteGridByRequestPathAndStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchPath1
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchPath1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchPath1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchPath1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchPath1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchPath1WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createProduct', 'name', 'test') . ".html"); // stepKey: fillRedirectPathFilterSearchPath1
		$I->selectOption(".admin__data-grid-filters select[name='store_id']", "storeView" . msq("storeViewData")); // stepKey: fillStoreViewSearchPath1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchPath1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchPath1
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchPath1
		$I->see("catalog/product/view/id/{$productId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchPath1
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchPath1
		$I->comment("Exiting Action Group [searchPath1] AdminFilterUrlRewriteGridByRequestPathAndStoreViewActionGroup");
		$I->comment("Entering Action Group [seeStoreValueForProductId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->see("store" . msq("customStore"), "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Store View')]/preceding-sibling::th)+1]"); // stepKey: seeStoreValueForCategoryIdSeeStoreValueForProductId
		$I->comment("Exiting Action Group [seeStoreValueForProductId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->comment("Entering Action Group [seeStoreViewValueForProductId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
		$I->see("storeView" . msq("storeViewData"), "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Store View')]/preceding-sibling::th)+1]"); // stepKey: seeStoreValueForCategoryIdSeeStoreViewValueForProductId
		$I->comment("Exiting Action Group [seeStoreViewValueForProductId] AssertAdminStoreValueIsSetForUrlRewriteActionGroup");
	}
}
