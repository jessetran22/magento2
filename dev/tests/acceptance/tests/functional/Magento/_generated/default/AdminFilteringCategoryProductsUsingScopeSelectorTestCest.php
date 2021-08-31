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
 * @Title("MAGETWO-48850: Filtering Category Products using scope selector")
 * @Description("Filtering Category Products using scope selector<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminFilteringCategoryProductsUsingScopeSelectorTest.xml<br>")
 * @TestCaseId("MAGETWO-48850")
 * @group catalog
 */
class AdminFilteringCategoryProductsUsingScopeSelectorTestCest
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
		$I->comment("Create website, Store and Store View");
		$I->comment("Entering Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateSecondWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Custom Website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteNameCreateSecondWebsite
		$I->fillField("#website_code", "custom_website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteCodeCreateSecondWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateSecondWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateSecondWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateSecondWebsite
		$I->comment("Exiting Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createSecondStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreGroup
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Custom Website" . msq("secondCustomWebsite")); // stepKey: selectWebsiteCreateSecondStoreGroup
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateSecondStoreGroup
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateSecondStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStoreGroup
		$I->comment("Exiting Action Group [createSecondStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "Second Store View " . msq("SecondStoreUnique")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "second_store_view_" . msq("SecondStoreUnique")); // stepKey: enterStoreViewCodeCreateSecondStoreView
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
		$I->comment("Create Simple Product and Category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct0", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct0
		$I->createEntity("createProduct1", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct2
		$I->createEntity("createProduct12", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct12
		$I->comment("Set filter to product name and product0 not assigned to any website");
		$I->comment("Entering Action Group [searchForProduct0] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct0
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct0
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct0
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct0
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProduct0WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct0', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct0
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct0
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProduct0WaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct0] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [clickOpenProductForEdit0] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct0', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowClickOpenProductForEdit0
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOpenProductForEdit0
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct0', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageClickOpenProductForEdit0
		$I->comment("Exiting Action Group [clickOpenProductForEdit0] OpenEditProductOnBackendActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSection
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: clickToOpenWebsiteSection
		$I->waitForPageLoad(30); // stepKey: clickToOpenWebsiteSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForToOpenedWebsiteSection
		$I->uncheckOption("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsite
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Set filter to product name and product2 in website 2 only");
		$I->comment("Entering Action Group [searchForProduct2] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct2
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct2
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct2
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct2
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProduct2WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct2', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct2
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct2] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [clickOpenProductForEdit2] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct2', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowClickOpenProductForEdit2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOpenProductForEdit2
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct2', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageClickOpenProductForEdit2
		$I->comment("Exiting Action Group [clickOpenProductForEdit2] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [selectProductInWebsites] SelectProductInWebsitesActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSelectProductInWebsitesWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectProductInWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectProductInWebsites
		$I->checkOption("//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectProductInWebsites
		$I->comment("Exiting Action Group [selectProductInWebsites] SelectProductInWebsitesActionGroup");
		$I->uncheckOption("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsite1
		$I->comment("Entering Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->comment("Set filter to product name and product12 assigned to both websites 1 and 2");
		$I->comment("Entering Action Group [searchForProduct12] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct12
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct12
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct12
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct12
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProduct12WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct12', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct12
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct12
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProduct12WaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct12] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [clickOpenProductForEdit12] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct12', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowClickOpenProductForEdit12
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOpenProductForEdit12
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct12', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageClickOpenProductForEdit12
		$I->comment("Exiting Action Group [clickOpenProductForEdit12] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [selectProductInWebsites1] SelectProductInWebsitesActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSelectProductInWebsites1
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSelectProductInWebsites1WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionSelectProductInWebsites1
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectProductInWebsites1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectProductInWebsites1
		$I->checkOption("//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectProductInWebsites1
		$I->comment("Exiting Action Group [selectProductInWebsites1] SelectProductInWebsitesActionGroup");
		$I->comment("Entering Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct3
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct3
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct3WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct3WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct3
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct3
		$I->comment("Exiting Action Group [saveProduct3] SaveProductFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Custom Website" . msq("secondCustomWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Custom Website" . msq("secondCustomWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
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
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [clearProductsFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductsFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductsFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductsFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductsFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsFilter] ClearProductsFilterActionGroup");
		$I->deleteEntity("createProduct0", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createProduct12", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Filtering Category Products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminFilteringCategoryProductsUsingScopeSelectorTest(AcceptanceTester $I)
	{
		$I->comment("Step 1-2: Open Category page and Set scope selector to All Store Views");
		$I->comment("Entering Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: clickCategoryName
		$I->waitForPageLoad(30); // stepKey: clickCategoryNameWaitForPageLoad
		$I->click("div[data-index='assign_products'] .fieldset-wrapper-title"); // stepKey: openProductSection
		$I->waitForPageLoad(30); // stepKey: openProductSectionWaitForPageLoad
		$grabTextFromCategory = $I->grabTextFrom("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: grabTextFromCategory
		$I->waitForPageLoad(30); // stepKey: grabTextFromCategoryWaitForPageLoad
		$I->assertRegExp("/\(4\)$/", $grabTextFromCategory, "wrongCountProductOnAllStoreViews"); // stepKey: checkCountProducts
		$I->see($I->retrieveEntityField('createProduct0', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct0', 'name', 'test') . "')]"); // stepKey: seeProductName
		$I->see($I->retrieveEntityField('createProduct1', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]"); // stepKey: seeProductName1
		$I->see($I->retrieveEntityField('createProduct2', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]"); // stepKey: seeProductName2
		$I->see($I->retrieveEntityField('createProduct12', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct12', 'name', 'test') . "')]"); // stepKey: seeProductName3
		$I->comment("Step 3: Set scope selector to Website1( Storeview for the Website 1)");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->comment("Entering Action Group [swichToDefaultStoreView] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwichToDefaultStoreView
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwichToDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwichToDefaultStoreViewWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]"); // stepKey: clickStoreViewByNameSwichToDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwichToDefaultStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwichToDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwichToDefaultStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwichToDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwichToDefaultStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwichToDefaultStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwichToDefaultStoreView
		$I->see("Default Store View", ".store-switcher"); // stepKey: seeNewStoreViewNameSwichToDefaultStoreView
		$I->comment("Exiting Action Group [swichToDefaultStoreView] AdminSwitchStoreViewActionGroup");
		$grabTextFromCategory1 = $I->grabTextFrom("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: grabTextFromCategory1
		$I->waitForPageLoad(30); // stepKey: grabTextFromCategory1WaitForPageLoad
		$I->assertRegExp("/\(2\)$/", $grabTextFromCategory1, "wrongCountProductOnWebsite1"); // stepKey: checkCountProducts1
		$I->click("div[data-index='assign_products'] .fieldset-wrapper-title"); // stepKey: openProductSection1
		$I->waitForPageLoad(30); // stepKey: openProductSection1WaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct1', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]"); // stepKey: seeProductName4
		$I->see($I->retrieveEntityField('createProduct12', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct12', 'name', 'test') . "')]"); // stepKey: seeProductName5
		$I->dontSee($I->retrieveEntityField('createProduct0', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct0', 'name', 'test') . "')]"); // stepKey: dontSeeProductName
		$I->dontSee($I->retrieveEntityField('createProduct2', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]"); // stepKey: dontSeeProductName1
		$I->comment("Step 4: Set scope selector to Website2 ( StoreView for Website 2)");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage1
		$I->comment("Entering Action Group [swichToSecondStoreView] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwichToSecondStoreView
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwichToSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwichToSecondStoreViewWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Second Store View " . msq("SecondStoreUnique") . "')]"); // stepKey: clickStoreViewByNameSwichToSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwichToSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwichToSecondStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwichToSecondStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwichToSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwichToSecondStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwichToSecondStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwichToSecondStoreView
		$I->see("Second Store View " . msq("SecondStoreUnique"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwichToSecondStoreView
		$I->comment("Exiting Action Group [swichToSecondStoreView] AdminSwitchStoreViewActionGroup");
		$I->click("div[data-index='assign_products'] .fieldset-wrapper-title"); // stepKey: openProductSection2
		$I->waitForPageLoad(30); // stepKey: openProductSection2WaitForPageLoad
		$grabTextFromCategory2 = $I->grabTextFrom("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: grabTextFromCategory2
		$I->waitForPageLoad(30); // stepKey: grabTextFromCategory2WaitForPageLoad
		$I->assertRegExp("/\(2\)$/", $grabTextFromCategory2, "wrongCountProductOnWebsite2"); // stepKey: checkCountProducts2
		$I->see($I->retrieveEntityField('createProduct2', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]"); // stepKey: seeProductName6
		$I->see($I->retrieveEntityField('createProduct12', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct12', 'name', 'test') . "')]"); // stepKey: seeProductName7
		$I->dontSee($I->retrieveEntityField('createProduct0', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct0', 'name', 'test') . "')]"); // stepKey: dontSeeProductName2
		$I->dontSee($I->retrieveEntityField('createProduct1', 'name', 'test'), "//table[@id='catalog_category_products_table']//td[contains(., '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]"); // stepKey: dontSeeProductName3
	}
}
