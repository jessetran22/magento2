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
 * @Title("MC-17607: Possibility to set up watermark for a swatch image type")
 * @Description("Possibility to set up watermark for a swatch image type<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminSetUpWatermarkForSwatchImageTest.xml<br>")
 * @TestCaseId("MC-17607")
 * @group swatches
 */
class AdminSetUpWatermarkForSwatchImageTestCest
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
		$I->comment("Login as Admin");
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Log out");
		$I->comment("Log out");
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
	 * @Features({"Swatches"})
	 * @Stories({"Product Swatches Images"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSetUpWatermarkForSwatchImageTest(AcceptanceTester $I)
	{
		$I->comment("Go to Admin > Content > Configuration	page");
		$I->comment("Go to Configuration Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPage
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
		$I->comment("Select Edit next to the Default Store View");
		$I->comment("Select Edit next to the Default Store View");
		$I->comment("Entering Action Group [clickToEditDefaultStoreView] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickToEditDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickToEditDefaultStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickToEditDefaultStoreView
		$I->comment("Exiting Action Group [clickToEditDefaultStoreView] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->comment("Expand the Product Image Watermarks section");
		$I->comment("Expand the Product Image Watermarks section");
		$I->click("[data-index='watermark']"); // stepKey: clickToProductImageWatermarks
		$I->waitForPageLoad(30); // stepKey: waitForWatermarksPage
		$I->comment("See Base, Thumbnail, Small image types are displayed");
		$I->comment("See Base, Thumbnail, Small image types are displayed");
		$I->seeElement("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(text(), 'Base')]"); // stepKey: seeElementBaseWatermark
		$I->waitForElementVisible("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(text(), 'Thumbnail')]", 30); // stepKey: waitForThumbnailVisible
		$I->seeElement("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(text(), 'Thumbnail')]"); // stepKey: seeElementThumbnailWatermark
		$I->waitForElementVisible("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(text(), 'Small')]", 30); // stepKey: waitForSmallVisible
		$I->seeElement("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(text(), 'Small')]"); // stepKey: seeElementSmallWatermark
		$I->comment("See Swatch Image type is absent");
		$I->comment("See Swatch Image type is absent");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->dontSeeElement("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(text(), 'Swatch')]"); // stepKey: dontSeeImageWatermarkSwatchImage
	}
}
