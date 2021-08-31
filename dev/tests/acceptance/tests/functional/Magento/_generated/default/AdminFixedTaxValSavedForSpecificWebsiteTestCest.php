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
 * @Title("MC-17182: Fixed Product Tax value is saved correctly for Specific Website")
 * @Description("Fixed Product Tax value is saved correctly for Specific Website<h3>Test files</h3>app/code/Magento/Weee/Test/Mftf/Test/AdminFixedTaxValSavedForSpecificWebsiteTest.xml<br>")
 * @TestCaseId("MC-17182")
 * @group tax
 */
class AdminFixedTaxValSavedForSpecificWebsiteTestCest
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
		$I->comment("Create product attribute and add it to default attribute set />");
		$I->comment("Create product attribute and add it to default attribute set");
		$I->createEntity("createProductFPTAttribute", "hook", "FPTProductAttribute", [], []); // stepKey: createProductFPTAttribute
		$I->createEntity("addToDefaultAttributeSet", "hook", "AddToDefaultSet", ["createProductFPTAttribute"], []); // stepKey: addToDefaultAttributeSet
		$I->comment("Create product, category and log in");
		$I->comment("Create product, category and log in");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create website, store and store view");
		$I->comment("Create website, store and store view");
		$I->comment("Entering Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateSecondWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "WebSite" . msq("NewWebSiteData")); // stepKey: enterWebsiteNameCreateSecondWebsite
		$I->fillField("#website_code", "WebSiteCode" . msq("NewWebSiteData")); // stepKey: enterWebsiteCodeCreateSecondWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateSecondWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateSecondWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateSecondWebsite
		$I->comment("Exiting Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "WebSite" . msq("NewWebSiteData")); // stepKey: selectWebsiteCreateSecondStore
		$I->fillField("#group_name", "Store" . msq("NewStoreData")); // stepKey: enterStoreGroupNameCreateSecondStore
		$I->fillField("#group_code", "StoreCode" . msq("NewStoreData")); // stepKey: enterStoreGroupCodeCreateSecondStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStore
		$I->comment("Exiting Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Store" . msq("NewStoreData")); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateSecondStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateSecondStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateSecondStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateSecondStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateSecondStoreView
		$I->comment("Exiting Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Set catalog price scope to Global");
		$I->comment("Set catalog price scope to Global");
		$setPriceScopeGlobal = $I->magentoCLI("config:set catalog/price/scope 0", 60); // stepKey: setPriceScopeGlobal
		$I->comment($setPriceScopeGlobal);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set catalog price scope to Global");
		$I->comment("Set catalog price scope to Global");
		$setPriceScopeGlobal = $I->magentoCLI("config:set catalog/price/scope 0", 60); // stepKey: setPriceScopeGlobal
		$I->comment($setPriceScopeGlobal);
		$I->comment("Delete created data and log out");
		$I->comment("Delete created data and log out");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProductFPTAttribute", "hook"); // stepKey: deleteProductFPTAttribute
		$I->comment("Entering Action Group [deleteCustomWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCustomWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "WebSite" . msq("NewWebSiteData")); // stepKey: fillSearchWebsiteFieldDeleteCustomWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomWebsiteWaitForPageLoad
		$I->see("WebSite" . msq("NewWebSiteData"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteCustomWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteCustomWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCustomWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteCustomWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteCustomWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteCustomWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCustomWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteCustomWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteCustomWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteCustomWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteCustomWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteCustomWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteCustomWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Weee"})
	 * @Stories({"Website Specific Fixed Product Tax"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminFixedTaxValSavedForSpecificWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Go to product edit page and assign it to created website");
		$I->comment("Go to product edit page and assign it to created website");
		$I->comment("Entering Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [selectWebsiteInProduct] SelectProductInWebsitesActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSelectWebsiteInProduct
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSelectWebsiteInProductWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionSelectWebsiteInProduct
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectWebsiteInProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectWebsiteInProduct
		$I->checkOption("//label[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectWebsiteInProduct
		$I->comment("Exiting Action Group [selectWebsiteInProduct] SelectProductInWebsitesActionGroup");
		$I->comment("Entering Action Group [saveProductFirstTime] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductFirstTime
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductFirstTime
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFirstTimeWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductFirstTime
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFirstTimeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductFirstTime
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductFirstTime
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductFirstTime
		$I->comment("Exiting Action Group [saveProductFirstTime] SaveProductFormActionGroup");
		$I->comment("Add Fixed Product Tax attribute");
		$I->comment("Add Fixed Product Tax attribute");
		$I->comment("Entering Action Group [addFixedProductTaxAttr] AdminProductAddFPTValueActionGroup");
		$I->click("[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] [data-action='add_new_row']"); // stepKey: clickAddFPTButton1AddFixedProductTaxAttr
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFixedProductTaxAttr
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] table tbody tr.data-row:last-child select[name*='[country]']", "US"); // stepKey: selectcountryForFPTAddFixedProductTaxAttr
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] table tbody tr.data-row:last-child select[name*='[state]']", "California"); // stepKey: selectstateForFPTAddFixedProductTaxAttr
		$I->fillField("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] table tbody tr.data-row:last-child input[name*='[value]']", "10"); // stepKey: setTaxvalueForFPTAddFixedProductTaxAttr
		$I->comment("Exiting Action Group [addFixedProductTaxAttr] AdminProductAddFPTValueActionGroup");
		$I->comment("Entering Action Group [saveProductSecondTime] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductSecondTime
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductSecondTimeWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductSecondTime
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductSecondTimeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductSecondTime
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductSecondTime
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductSecondTime
		$I->comment("Exiting Action Group [saveProductSecondTime] SaveProductFormActionGroup");
		$I->comment("Check if created tax attribute is saved");
		$I->comment("Check if created tax attribute is saved");
		$I->seeElement("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] table tbody tr.data-row:last-child input[name*='[value]']"); // stepKey: checkIfTaxAttributeSaved
		$I->comment("See available websites only 'All Websites'");
		$I->comment("See available websites only 'All Websites'");
		$I->seeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'All Websites')]"); // stepKey: seeAllWebsites
		$I->dontSeeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]"); // stepKey: dontSeeSecondWebsite
		$I->dontSeeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'Main Website')]"); // stepKey: dontSeeMainWebsite
		$I->comment("Set catalog price scope to Website");
		$I->comment("Set catalog price scope to Website");
		$setPriceScopeWebsite = $I->magentoCLI("config:set catalog/price/scope 1", 60); // stepKey: setPriceScopeWebsite
		$I->comment($setPriceScopeWebsite);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("See available websites only 'All Websites'");
		$I->comment("See available websites 'All Websites', 'Main Website' and Second website");
		$I->comment("Entering Action Group [goToProductPageSecondTime] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGoToProductPageSecondTime
		$I->comment("Exiting Action Group [goToProductPageSecondTime] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadSecondTime
		$I->seeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'All Websites')]"); // stepKey: checkAllWebsitesInDropDown
		$I->seeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'Main Website')]"); // stepKey: checkMainWebsiteInDropDown
		$I->seeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]"); // stepKey: checkSecondWebsitesInDropDown
		$I->comment("Entering Action Group [unassignWebsiteInProduct] UnassignWebsiteFromProductActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesUnassignWebsiteInProduct
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesUnassignWebsiteInProductWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionUnassignWebsiteInProduct
		$I->waitForPageLoad(30); // stepKey: expandSectionUnassignWebsiteInProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedUnassignWebsiteInProduct
		$I->uncheckOption("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: unSelectWebsiteUnassignWebsiteInProduct
		$I->comment("Exiting Action Group [unassignWebsiteInProduct] UnassignWebsiteFromProductActionGroup");
		$I->comment("Entering Action Group [saveProductThirdTime] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductThirdTime
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductThirdTimeWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductThirdTime
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductThirdTimeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductThirdTime
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductThirdTime
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductThirdTime
		$I->comment("Exiting Action Group [saveProductThirdTime] SaveProductFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSavedProductLoad
		$I->seeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'All Websites')]"); // stepKey: checkAllWebsitesInDropDownSecondTime
		$I->dontSeeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'Main Website')]"); // stepKey: checkNoMainWebsiteInDropDown
		$I->seeElement("(//select[contains(@name, 'product[" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "]') and contains(@name, '[website_id]')])/option[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]"); // stepKey: checkSecondWebsitesInDropDownSecondTime
		$I->comment("Check if created tax attribute is saved");
		$I->comment("Check if created tax attribute is saved");
		$I->seeInField("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] table tbody tr.data-row:last-child input[name*='[value]']", "10.0000"); // stepKey: checkTaxAttributeSaved
	}
}
