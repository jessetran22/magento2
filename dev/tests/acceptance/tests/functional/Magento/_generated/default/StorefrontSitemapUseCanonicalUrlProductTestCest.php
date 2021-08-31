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
 * @group Rss
 * @Title("[NO TESTCASEID]: Sitemap use canonical for product url")
 * @Description("RSS Feed always use canonical url for product<h3>Test files</h3>app/code/Magento/Sitemap/Test/Mftf/Test/StorefrontSitemapUseCanonicalUrlProductTest.xml<br>")
 */
class StorefrontSitemapUseCanonicalUrlProductTestCest
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
		$enableUseCategoryPathForProductUrl = $I->magentoCLI("config:set catalog/seo/product_use_categories 1", 60); // stepKey: enableUseCategoryPathForProductUrl
		$I->comment($enableUseCategoryPathForProductUrl);
		$enableUseCanonicalForProduct = $I->magentoCLI("config:set catalog/seo/product_canonical_tag 1", 60); // stepKey: enableUseCanonicalForProduct
		$I->comment($enableUseCanonicalForProduct);
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProductApi", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProductApi
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToMarketingSiteMapPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToMarketingSiteMapPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToMarketingSiteMapPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToMarketingSiteMapPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-sitemap-catalog-sitemap']"); // stepKey: clickOnSubmenuItemNavigateToMarketingSiteMapPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToMarketingSiteMapPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToMarketingSiteMapPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [navigateToNewSitemapPage] AdminMarketingSiteMapNavigateNewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/sitemap/new/"); // stepKey: openNewSiteMapPageNavigateToNewSitemapPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToNewSitemapPage
		$I->comment("Exiting Action Group [navigateToNewSitemapPage] AdminMarketingSiteMapNavigateNewActionGroup");
		$I->comment("Entering Action Group [createAndGenerateSitemap] AdminMarketingSiteMapFillFormSaveAndGenerateActionGroup");
		$I->fillField("input[name='sitemap_filename']", msq("UniqueSitemapName") . "sitemap.xml"); // stepKey: fillFilenameCreateAndGenerateSitemap
		$I->fillField("input[name='sitemap_path']", "/"); // stepKey: fillPathCreateAndGenerateSitemap
		$I->click("#generate"); // stepKey: saveAndGenerateSiteMapCreateAndGenerateSitemap
		$I->waitForPageLoad(10); // stepKey: saveAndGenerateSiteMapCreateAndGenerateSitemapWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCreateAndGenerateSitemap
		$I->comment("Exiting Action Group [createAndGenerateSitemap] AdminMarketingSiteMapFillFormSaveAndGenerateActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProductApi", "hook"); // stepKey: deleteSimple
		$disableUseCategoryPathForProductUrl = $I->magentoCLI("config:set catalog/seo/product_use_categories 0", 60); // stepKey: disableUseCategoryPathForProductUrl
		$I->comment($disableUseCategoryPathForProductUrl);
		$disableUseCanonicalForProduct = $I->magentoCLI("config:set catalog/seo/product_canonical_tag 0", 60); // stepKey: disableUseCanonicalForProduct
		$I->comment($disableUseCanonicalForProduct);
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
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
	 * @Stories({"Sitemap use canonical product url"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sitemap"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSitemapUseCanonicalUrlProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [clickFirstLinkGrid] AdminSiteMapGridClickFirstRowLinkActionGroup");
		$I->click("//td[contains(@class, 'col-link')][1]/a"); // stepKey: clickFirstLinkClickFirstLinkGrid
		$I->comment("Exiting Action Group [clickFirstLinkGrid] AdminSiteMapGridClickFirstRowLinkActionGroup");
		$I->see(getenv("MAGENTO_BASE_URL") . $I->retrieveEntityField('createSimpleProductApi', 'custom_attributes[url_key]', 'test')); // stepKey: seeCanonicalUrl
	}
}
