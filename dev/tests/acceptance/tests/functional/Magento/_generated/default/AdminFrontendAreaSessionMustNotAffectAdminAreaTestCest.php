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
 * @Title("MC-12353: Frontend area session must not affect admin area")
 * @Description("Frontend area session must not affect admin area<h3>Test files</h3>app/code/Magento/PageCache/Test/Mftf/Test/AdminFrontendAreaSessionMustNotAffectAdminAreaTest.xml<br>")
 * @TestCaseId("MC-12353")
 * @group backend
 * @group pagecache
 * @group cookie
 */
class AdminFrontendAreaSessionMustNotAffectAdminAreaTestCest
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
		$I->comment("Create Data");
		$I->createEntity("createCategoryA", "hook", "_defaultCategory", [], []); // stepKey: createCategoryA
		$I->createEntity("createCategoryB", "hook", "SubCategoryWithParent", ["createCategoryA"], []); // stepKey: createCategoryB
		$I->createEntity("createCategoryC", "hook", "SubCategoryWithParent", ["createCategoryB"], []); // stepKey: createCategoryC
		$I->createEntity("createProduct1", "hook", "ApiSimpleProduct", ["createCategoryC"], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "ApiSimpleProduct", ["createCategoryC"], []); // stepKey: createProduct2
		$I->createEntity("createProduct3", "hook", "ApiSimpleProduct", ["createCategoryA"], []); // stepKey: createProduct3
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "full_page"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->resetCookie("PHPSESSID"); // stepKey: resetSessionCookie
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete data");
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createProduct3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("createCategoryC", "hook"); // stepKey: deleteCategoryC
		$I->deleteEntity("createCategoryB", "hook"); // stepKey: deleteCategoryB
		$I->deleteEntity("createCategoryA", "hook"); // stepKey: deleteCategoryA
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Backend"})
	 * @Features({"PageCache"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminFrontendAreaSessionMustNotAffectAdminAreaTest(AcceptanceTester $I)
	{
		$I->comment("1. Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("2. Navigate Go to \"Catalog\"->\"Products\"");
		$I->comment("Entering Action Group [onCatalogProductPage] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOnCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOnCatalogProductPage
		$I->comment("Exiting Action Group [onCatalogProductPage] AdminProductCatalogPageOpenActionGroup");
		$I->comment("3. Open separate tab with Storefront");
		$I->openNewTab(); // stepKey: openNewTab
		$I->comment("4. Navigate to Men -> \"Tops\" -> \"Jackets\"");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategoryA', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createCategoryB', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createCategoryC', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPage
		$I->comment("5. Open admin tab with page with products. Reload this page twice.");
		$I->switchToPreviousTab(); // stepKey: switchToPreviousTab
		$I->comment("Entering Action Group [reloadAdminCatalogPageFirst] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadAdminCatalogPageFirst
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadAdminCatalogPageFirst
		$I->comment("Exiting Action Group [reloadAdminCatalogPageFirst] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Entering Action Group [reloadAdminCatalogPageSecond] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadAdminCatalogPageSecond
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadAdminCatalogPageSecond
		$I->comment("Exiting Action Group [reloadAdminCatalogPageSecond] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->seeInTitle("Products / Inventory / Catalog / Magento Admin"); // stepKey: seeAdminProductsPageTitle
		$I->see("Products", ".page-header h1.page-title"); // stepKey: seeAdminProductsPageHeader
		$I->switchToNextTab(); // stepKey: switchToFrontendTab
		$I->closeTab(); // stepKey: closeFrontendTab
	}
}
