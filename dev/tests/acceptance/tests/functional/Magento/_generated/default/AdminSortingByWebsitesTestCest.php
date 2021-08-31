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
 * @Title("[NO TESTCASEID]: Sorting by websites in Admin")
 * @Description("Sorting products by websites in Admin<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminSortingByWebsitesTest.xml<br>")
 */
class AdminSortingByWebsitesTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("productAssignedToCustomWebsite", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: productAssignedToCustomWebsite
		$I->createEntity("productAssignedToMainWebsite", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: productAssignedToMainWebsite
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
		$I->comment("Entering Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddStoreCodeToUrls
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: expandUrlSectionTabAddStoreCodeToUrls
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrlAddStoreCodeToUrls
		$I->uncheckOption("#web_url_use_store_inherit"); // stepKey: uncheckUseSystemValueAddStoreCodeToUrls
		$I->selectOption("#web_url_use_store", "Yes"); // stepKey: enableStoreCodeAddStoreCodeToUrls
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsAddStoreCodeToUrls
		$I->click("#save"); // stepKey: saveConfigAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: saveConfigAddStoreCodeToUrlsWaitForPageLoad
		$I->comment("Exiting Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("productAssignedToCustomWebsite", "hook"); // stepKey: deleteProductAssignedToCustomWebsite
		$I->deleteEntity("productAssignedToMainWebsite", "hook"); // stepKey: deleteProductAssignedToMainWebsite
		$I->comment("Entering Action Group [deleteTestWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteTestWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteTestWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteTestWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteTestWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteTestWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteTestWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteTestWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteTestWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteTestWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteTestWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteTestWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteTestWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteTestWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTestWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToProductCatalogPage
		$I->comment("Exiting Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPagetoResetResetUrlOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetUrlOption
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: closeUrlSectionTabResetUrlOption
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrl2ResetUrlOption
		$I->comment("<uncheckOption selector=\"\{\{UrlOptionsSection.systemValueForStoreCode\}\}\" stepKey=\"uncheckUseSystemValue\"/>");
		$I->selectOption("#web_url_use_store", "No"); // stepKey: enableStoreCodeResetUrlOption
		$I->checkOption("#web_url_use_store_inherit"); // stepKey: checkUseSystemValueResetUrlOption
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsResetUrlOption
		$I->click("#save"); // stepKey: saveConfigResetUrlOption
		$I->waitForPageLoad(30); // stepKey: saveConfigResetUrlOptionWaitForPageLoad
		$I->comment("Exiting Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"View sorting by websites"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSortingByWebsitesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCatalogProductGrid] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageNavigateToCatalogProductGrid
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadNavigateToCatalogProductGrid
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentNavigateToCatalogProductGrid
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentNavigateToCatalogProductGridWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToCatalogProductGrid] AdminClearFiltersActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [assignCustomWebsiteToProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('productAssignedToCustomWebsite', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowAssignCustomWebsiteToProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssignCustomWebsiteToProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('productAssignedToCustomWebsite', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageAssignCustomWebsiteToProduct
		$I->comment("Exiting Action Group [assignCustomWebsiteToProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [scrollToWebsites] AdminChangeWebSiteAssignedToProductActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsiteSectionHeaderScrollToWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsiteSectionHeaderScrollToWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: clickProductInWebsiteSectionHeaderScrollToWebsites
		$I->waitForPageLoad(30); // stepKey: clickProductInWebsiteSectionHeaderScrollToWebsitesWaitForPageLoad
		$I->checkOption("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: checkWebsiteScrollToWebsites
		$I->uncheckOption("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsiteScrollToWebsites
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSectionScrollToWebsites
		$I->click("#save-button"); // stepKey: clickSaveButtonScrollToWebsites
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonScrollToWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductSavedScrollToWebsites
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertProductSaveSuccessMessageScrollToWebsites
		$I->comment("Exiting Action Group [scrollToWebsites] AdminChangeWebSiteAssignedToProductActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [navigateToCatalogProductGridToSortByWebsite] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToCatalogProductGridToSortByWebsite
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToCatalogProductGridToSortByWebsite
		$I->comment("Exiting Action Group [navigateToCatalogProductGridToSortByWebsite] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clickWebsitesHeaderToSortAsc] AdminSortProductsGridByActionGroup");
		$I->click("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Websites']"); // stepKey: clickWebsitesHeaderToSortClickWebsitesHeaderToSortAsc
		$I->waitForPageLoad(30); // stepKey: clickWebsitesHeaderToSortClickWebsitesHeaderToSortAscWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForApplyingChangesClickWebsitesHeaderToSortAsc
		$I->comment("Exiting Action Group [clickWebsitesHeaderToSortAsc] AdminSortProductsGridByActionGroup");
		$I->see("Main Website", "//*[@id='container']//tr[1]/td"); // stepKey: checkIfProduct1WebsitesAsc
		$I->comment("Entering Action Group [clickWebsitesHeaderToSortDesc] AdminSortProductsGridByActionGroup");
		$I->click("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Websites']"); // stepKey: clickWebsitesHeaderToSortClickWebsitesHeaderToSortDesc
		$I->waitForPageLoad(30); // stepKey: clickWebsitesHeaderToSortClickWebsitesHeaderToSortDescWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForApplyingChangesClickWebsitesHeaderToSortDesc
		$I->comment("Exiting Action Group [clickWebsitesHeaderToSortDesc] AdminSortProductsGridByActionGroup");
		$I->see("Second Website" . msq("customWebsite"), "//*[@id='container']//tr[1]/td"); // stepKey: checkIfProduct1WebsitesDesc
	}
}
