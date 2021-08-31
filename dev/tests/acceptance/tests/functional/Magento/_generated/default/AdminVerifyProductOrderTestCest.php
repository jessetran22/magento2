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
 * @Title("MC-14207: Admin should see product types in specified order")
 * @Description("Product Type Order should be Simple -> Configurable -> Grouped -> Virtual -> Bundle -> Downloadable -> EE<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminVerifyProductOrderTest.xml<br>")
 * @TestCaseId("MC-14207")
 * @group mtf_migrated
 * @group product
 */
class AdminVerifyProductOrderTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
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
	 * @Stories({"Verify Product Order"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyProductOrderTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToProductCatalogPage
		$I->comment("Exiting Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [verifyProductTypeOrder] VerifyProductTypeOrder");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownVerifyProductTypeOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownVerifyProductTypeOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadVerifyProductTypeOrder
		$I->seeElement("//li[not(preceding-sibling::li)]//span[@title='Simple Product']"); // stepKey: seeSimpleInOrderVerifyProductTypeOrder
		$I->seeElement("//li[not(preceding-sibling::li[span[@title='Bundle Product']]) and not(preceding-sibling::li[span[@title='Downloadable Product']]) and not(following-sibling::li[span[@title='Simple Product']]) and not(following-sibling::li[span[@title='Configurable Product']]) and not(following-sibling::li[span[@title='Grouped Product']])]/span[@title='Virtual Product']"); // stepKey: seeVirtualInOrderVerifyProductTypeOrder
		$I->seeElement("//li[not(preceding-sibling::li[span[@title='Downloadable Product']]) and not(following-sibling::li[span[@title='Simple Product']]) and not(following-sibling::li[span[@title='Configurable Product']]) and not(following-sibling::li[span[@title='Grouped Product']]) and not(following-sibling::li[span[@title='Virtual Product']])]/span[@title='Bundle Product']"); // stepKey: seeBundleInOrderVerifyProductTypeOrder
		$I->seeElement("//li[not(following-sibling::li[span[@title='Bundle Product']]) and not(following-sibling::li[span[@title='Simple Product']]) and not(following-sibling::li[span[@title='Configurable Product']]) and not(following-sibling::li[span[@title='Grouped Product']]) and not(following-sibling::li[span[@title='Virtual Product']])]/span[@title='Downloadable Product']"); // stepKey: seeDownloadableInOrderVerifyProductTypeOrder
		$I->seeElement("//li[not(preceding-sibling::li[span[@title='Virtual Product']]) and not(preceding-sibling::li[span[@title='Grouped Product']]) and not(preceding-sibling::li[span[@title='Bundle Product']]) and not(preceding-sibling::li[span[@title='Downloadable Product']]) and not(following-sibling::li[span[@title='Simple Product']])]/span[@title='Configurable Product']"); // stepKey: seeConfigurableInOrderVerifyProductTypeOrder
		$I->seeElement("//li[not(preceding-sibling::li[span[@title='Virtual Product']]) and not(preceding-sibling::li[span[@title='Bundle Product']]) and not(preceding-sibling::li[span[@title='Downloadable Product']]) and not(following-sibling::li[span[@title='Simple Product']]) and not(following-sibling::li[span[@title='Configurable Product']])]/span[@title='Grouped Product']"); // stepKey: seeGroupedInOrderVerifyProductTypeOrder
		$I->comment("Exiting Action Group [verifyProductTypeOrder] VerifyProductTypeOrder");
	}
}
