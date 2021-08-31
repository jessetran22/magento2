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
 * @Description("Verify Magento native import products with replace behavior.<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminImportProductsWithReplaceBehaviorTest.xml<br>")
 * @Title("MC-14076: Verify Magento native import products with replace behavior.")
 * @TestCaseId("MC-14076")
 * @group importExport
 * @group mtf_migrated
 */
class AdminImportProductsWithReplaceBehaviorTestCest
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
		$I->comment("Create Simple Product1");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProduct1Fields['name'] = "SimpleProductForTest1";
		$createSimpleProduct1Fields['sku'] = "SimpleProductForTest1";
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct", ["createCategory"], $createSimpleProduct1Fields); // stepKey: createSimpleProduct1
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create Website");
		$I->comment("Entering Action Group [AdminCreateWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageAdminCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadAdminCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "secondWebsite"); // stepKey: enterWebsiteNameAdminCreateWebsite
		$I->fillField("#website_code", "second_website"); // stepKey: enterWebsiteCodeAdminCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteAdminCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteAdminCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadAdminCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageAdminCreateWebsite
		$I->comment("Exiting Action Group [AdminCreateWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create store group");
		$I->comment("Entering Action Group [AdminCreateStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewAdminCreateStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AdminCreateStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "secondWebsite"); // stepKey: selectWebsiteAdminCreateStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameAdminCreateStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeAdminCreateStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryAdminCreateStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupAdminCreateStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupAdminCreateStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadAdminCreateStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageAdminCreateStore
		$I->comment("Exiting Action Group [AdminCreateStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create store view");
		$I->comment("Entering Action Group [AdminCreateStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewAdminCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AdminCreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreAdminCreateStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameAdminCreateStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeAdminCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusAdminCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewAdminCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewAdminCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalAdminCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalAdminCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteAdminCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalAdminCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalAdminCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageAdminCreateStoreView
		$I->comment("Exiting Action Group [AdminCreateStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Create Simple Product2");
		$createSimpleProduct2Fields['name'] = "SimpleProductForTest2";
		$createSimpleProduct2Fields['sku'] = "SimpleProductForTest2";
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct", ["createCategory"], $createSimpleProduct2Fields); // stepKey: createSimpleProduct2
		$I->comment("Create Simple Product3");
		$createSimpleProduct3Fields['name'] = "SimpleProductForTest3";
		$createSimpleProduct3Fields['sku'] = "SimpleProductForTest3";
		$I->createEntity("createSimpleProduct3", "hook", "SimpleProduct", ["createCategory"], $createSimpleProduct3Fields); // stepKey: createSimpleProduct3
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete all products that replaced products in the before block post import");
		$I->deleteEntityByUrl("/V1/products/SimpleProductForTest1"); // stepKey: deleteSimpleProduct1
		$I->deleteEntityByUrl("/V1/products/SimpleProductForTest2"); // stepKey: deleteSimpleProduct2
		$I->deleteEntityByUrl("/V1/products/SimpleProductForTest3"); // stepKey: deleteSimpleProduct3
		$I->comment("Delete category created in the before block");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete website created in the before block");
		$I->comment("Logout");
		$I->comment("Entering Action Group [DeleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "secondWebsite"); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("secondWebsite", "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [DeleteWebsite] AdminDeleteWebsiteActionGroup");
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
	 * @Stories({"Import Products"})
	 * @Features({"ImportExport"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminImportProductsWithReplaceBehaviorTest(AcceptanceTester $I)
	{
		$I->comment("Import products with add/update behavior");
		$I->comment("Entering Action Group [adminImportProducts] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProducts
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProducts
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProducts
		$I->selectOption("#basic_behavior", "Replace"); // stepKey: selectImportBehaviorOptionAdminImportProducts
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionAdminImportProducts
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldAdminImportProducts
		$I->attachFile("#import_file", "catalog_import_products.csv"); // stepKey: attachFileForImportAdminImportProducts
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductsWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: clickImportButtonAdminImportProductsWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageAdminImportProducts
		$I->see("Created: 3, Updated: 0, Deleted: 3", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageAdminImportProducts
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageAdminImportProducts
		$I->comment("Exiting Action Group [adminImportProducts] AdminImportProductsActionGroup");
		$I->comment("Assert Simple Product1 on grid");
		$I->comment("Entering Action Group [assertSimpleProduct1OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageAssertSimpleProduct1OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInitialAssertSimpleProduct1OnAdminGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialAssertSimpleProduct1OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialAssertSimpleProduct1OnAdminGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAssertSimpleProduct1OnAdminGrid
		$I->fillField("input.admin__control-text[name='name']", "SimpleProductAfterImport1"); // stepKey: fillProductNameFilterAssertSimpleProduct1OnAdminGrid
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProductForTest1"); // stepKey: fillProductSkuFilterAssertSimpleProduct1OnAdminGrid
		$I->selectOption("select.admin__control-select[name='type_id']", "simple"); // stepKey: selectionProductTypeAssertSimpleProduct1OnAdminGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAssertSimpleProduct1OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAssertSimpleProduct1OnAdminGridWaitForPageLoad
		$I->see("SimpleProductAfterImport1", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridAssertSimpleProduct1OnAdminGrid
		$I->see("250.00", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductPriceInGridAssertSimpleProduct1OnAdminGrid
		$I->comment("Exiting Action Group [assertSimpleProduct1OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->comment("Assert Simple Product1 on edit page");
		$I->comment("Entering Action Group [assertSimpleProduct1OnEditPage] AssertProductInfoOnEditPageActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='SimpleProductForTest1']]"); // stepKey: clickOnProductRowAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProductForTest1"); // stepKey: seeProductSkuOnEditProductPageAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "SimpleProductAfterImport1"); // stepKey: seeProductNameAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProductForTest1"); // stepKey: seeProductSkuAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "250.00"); // stepKey: seeProductPriceAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "100"); // stepKey: seeProductQuantityAssertSimpleProduct1OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertSimpleProduct1OnEditPage] AssertProductInfoOnEditPageActionGroup");
		$I->comment("Assert Simple Product2 on grid");
		$I->comment("Entering Action Group [assertSimpleProduct2OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageAssertSimpleProduct2OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInitialAssertSimpleProduct2OnAdminGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialAssertSimpleProduct2OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialAssertSimpleProduct2OnAdminGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAssertSimpleProduct2OnAdminGrid
		$I->fillField("input.admin__control-text[name='name']", "SimpleProductAfterImport2"); // stepKey: fillProductNameFilterAssertSimpleProduct2OnAdminGrid
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProductForTest2"); // stepKey: fillProductSkuFilterAssertSimpleProduct2OnAdminGrid
		$I->selectOption("select.admin__control-select[name='type_id']", "simple"); // stepKey: selectionProductTypeAssertSimpleProduct2OnAdminGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAssertSimpleProduct2OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAssertSimpleProduct2OnAdminGridWaitForPageLoad
		$I->see("SimpleProductAfterImport2", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridAssertSimpleProduct2OnAdminGrid
		$I->see("300.00", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductPriceInGridAssertSimpleProduct2OnAdminGrid
		$I->comment("Exiting Action Group [assertSimpleProduct2OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->comment("Assert Simple Product2 on edit page");
		$I->comment("Entering Action Group [assertSimpleProduct2OnEditPage] AssertProductInfoOnEditPageActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='SimpleProductForTest2']]"); // stepKey: clickOnProductRowAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProductForTest2"); // stepKey: seeProductSkuOnEditProductPageAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "SimpleProductAfterImport2"); // stepKey: seeProductNameAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProductForTest2"); // stepKey: seeProductSkuAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "300.00"); // stepKey: seeProductPriceAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "100"); // stepKey: seeProductQuantityAssertSimpleProduct2OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertSimpleProduct2OnEditPage] AssertProductInfoOnEditPageActionGroup");
		$I->comment("Assert Simple Product3 on grid");
		$I->comment("Entering Action Group [assertSimpleProduct3OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageAssertSimpleProduct3OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInitialAssertSimpleProduct3OnAdminGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialAssertSimpleProduct3OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialAssertSimpleProduct3OnAdminGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAssertSimpleProduct3OnAdminGrid
		$I->fillField("input.admin__control-text[name='name']", "SimpleProductAfterImport3"); // stepKey: fillProductNameFilterAssertSimpleProduct3OnAdminGrid
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProductForTest3"); // stepKey: fillProductSkuFilterAssertSimpleProduct3OnAdminGrid
		$I->selectOption("select.admin__control-select[name='type_id']", "simple"); // stepKey: selectionProductTypeAssertSimpleProduct3OnAdminGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAssertSimpleProduct3OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAssertSimpleProduct3OnAdminGridWaitForPageLoad
		$I->see("SimpleProductAfterImport3", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridAssertSimpleProduct3OnAdminGrid
		$I->see("350.00", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductPriceInGridAssertSimpleProduct3OnAdminGrid
		$I->comment("Exiting Action Group [assertSimpleProduct3OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->comment("Assert Simple Product3 on edit page");
		$I->comment("Entering Action Group [assertSimpleProduct3OnEditPage] AssertProductInfoOnEditPageActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='SimpleProductForTest3']]"); // stepKey: clickOnProductRowAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProductForTest3"); // stepKey: seeProductSkuOnEditProductPageAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "SimpleProductAfterImport3"); // stepKey: seeProductNameAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProductForTest3"); // stepKey: seeProductSkuAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "350.00"); // stepKey: seeProductPriceAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "100"); // stepKey: seeProductQuantityAssertSimpleProduct3OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertSimpleProduct3OnEditPage] AssertProductInfoOnEditPageActionGroup");
		$I->comment("Assert SimpleProduct1 on store front");
		$I->comment("Entering Action Group [storeFrontSimpleProduct1Validation] StoreFrontProductValidationActionGroup");
		$I->amOnPage("/simple-product-for-test-1.html"); // stepKey: seeProductPageStoreFrontSimpleProduct1Validation
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageToLoadStoreFrontSimpleProduct1Validation
		$I->see("SimpleProductAfterImport1", ".base"); // stepKey: seeProductInStoreFrontPageStoreFrontSimpleProduct1Validation
		$I->see("SimpleProductForTest1", ".product.attribute.sku>.value"); // stepKey: seeCorrectSkuStoreFrontSimpleProduct1Validation
		$I->see("250.00", "div.price-box.price-final_price"); // stepKey: seeCorrectPriceStoreFrontSimpleProduct1Validation
		$I->comment("Exiting Action Group [storeFrontSimpleProduct1Validation] StoreFrontProductValidationActionGroup");
		$I->comment("Assert SimpleProduct2 on store front");
		$I->comment("Entering Action Group [storeFrontSimpleProduct2Validation] StoreFrontProductValidationActionGroup");
		$I->amOnPage("/simple-product-for-test-2.html"); // stepKey: seeProductPageStoreFrontSimpleProduct2Validation
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageToLoadStoreFrontSimpleProduct2Validation
		$I->see("SimpleProductAfterImport2", ".base"); // stepKey: seeProductInStoreFrontPageStoreFrontSimpleProduct2Validation
		$I->see("SimpleProductForTest2", ".product.attribute.sku>.value"); // stepKey: seeCorrectSkuStoreFrontSimpleProduct2Validation
		$I->see("300.00", "div.price-box.price-final_price"); // stepKey: seeCorrectPriceStoreFrontSimpleProduct2Validation
		$I->comment("Exiting Action Group [storeFrontSimpleProduct2Validation] StoreFrontProductValidationActionGroup");
		$I->comment("Assert SimpleProduct3 on store front");
		$I->comment("Entering Action Group [storeFrontSimpleProduct3Validation] StoreFrontProductValidationActionGroup");
		$I->amOnPage("/simple-product-for-test-3.html"); // stepKey: seeProductPageStoreFrontSimpleProduct3Validation
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageToLoadStoreFrontSimpleProduct3Validation
		$I->see("SimpleProductAfterImport3", ".base"); // stepKey: seeProductInStoreFrontPageStoreFrontSimpleProduct3Validation
		$I->see("SimpleProductForTest3", ".product.attribute.sku>.value"); // stepKey: seeCorrectSkuStoreFrontSimpleProduct3Validation
		$I->see("350.00", "div.price-box.price-final_price"); // stepKey: seeCorrectPriceStoreFrontSimpleProduct3Validation
		$I->comment("Exiting Action Group [storeFrontSimpleProduct3Validation] StoreFrontProductValidationActionGroup");
		$I->comment("Import products with replace behavior");
	}
}
