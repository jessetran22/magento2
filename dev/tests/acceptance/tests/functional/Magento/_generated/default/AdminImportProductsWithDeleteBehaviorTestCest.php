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
 * @Description("Verify Magento native import products with delete behavior.<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminImportProductsWithDeleteBehaviorTest.xml<br>")
 * @Title("MAGETWO-30587: Verify Magento native import products with delete behavior.")
 * @TestCaseId("MAGETWO-30587")
 * @group importExport
 */
class AdminImportProductsWithDeleteBehaviorTestCest
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
		$I->comment("Create Simple product");
		$createSimpleProductFields['name'] = "Simple Product for Test";
		$createSimpleProductFields['sku'] = "Simple Product for Test";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Create Virtual product");
		$createVirtualProductFields['name'] = "Virtual Product for Test";
		$createVirtualProductFields['sku'] = "Virtual Product for Test";
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], $createVirtualProductFields); // stepKey: createVirtualProduct
		$I->comment("Create Downloadable product");
		$createDownloadableProductFields['name'] = "Api Downloadable Product for Test";
		$createDownloadableProductFields['sku'] = "Api Downloadable Product for Test";
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], $createDownloadableProductFields); // stepKey: createDownloadableProduct
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
		$I->comment("Entering Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilters] AdminClearFiltersActionGroup");
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
	 * @Stories({"Verify Magento native import products with delete behavior."})
	 * @Features({"ImportExport"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminImportProductsWithDeleteBehaviorTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPage
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOption
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisible
		$I->selectOption("#basic_behavior", "Delete"); // stepKey: selectDeleteOption
		$I->attachFile("#import_file", "catalog_products.csv"); // stepKey: attachFileForImport
		$I->click("#upload_button"); // stepKey: clickCheckDataButton
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButton
		$I->waitForPageLoad(30); // stepKey: clickImportButtonWaitForPageLoad
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: assertSuccessMessage
		$I->see("Created: 0, Updated: 0, Deleted: 3", "#import_validation_messages .message-notice"); // stepKey: assertNotice
		$I->comment("Entering Action Group [searchSimpleProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchSimpleProductOnBackend
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchSimpleProductOnBackend
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchSimpleProductOnBackend
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchSimpleProductOnBackend
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchSimpleProductOnBackendWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchSimpleProductOnBackend
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchSimpleProductOnBackend
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchSimpleProductOnBackendWaitForPageLoad
		$I->comment("Exiting Action Group [searchSimpleProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage
		$I->comment("Entering Action Group [searchVirtualProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchVirtualProductOnBackend
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchVirtualProductOnBackend
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchVirtualProductOnBackend
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchVirtualProductOnBackend
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchVirtualProductOnBackendWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createVirtualProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchVirtualProductOnBackend
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchVirtualProductOnBackend
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchVirtualProductOnBackendWaitForPageLoad
		$I->comment("Exiting Action Group [searchVirtualProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage1
		$I->comment("Entering Action Group [searchDownloadableProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchDownloadableProductOnBackend
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchDownloadableProductOnBackend
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchDownloadableProductOnBackend
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchDownloadableProductOnBackend
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchDownloadableProductOnBackendWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createDownloadableProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchDownloadableProductOnBackend
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchDownloadableProductOnBackend
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchDownloadableProductOnBackendWaitForPageLoad
		$I->comment("Exiting Action Group [searchDownloadableProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage2
	}
}
