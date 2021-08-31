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
 * @Title("[NO TESTCASEID]: Correct view of Swatches while choosing color or upload image")
 * @Description("Correct view of Swatches while choosing color or upload image<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminCheckColorUploadChooserVisualSwatchTest.xml<br>")
 * @group Swatches
 */
class AdminCheckColorUploadChooserVisualSwatchTestCest
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
	 * @Features({"Swatches"})
	 * @Stories({"Check correct view of visual swatches"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckColorUploadChooserVisualSwatchTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [addNewProductAttribute] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageAddNewProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadAddNewProductAttribute
		$I->comment("Exiting Action Group [addNewProductAttribute] AdminNavigateToNewProductAttributePageActionGroup");
		$I->selectOption("#frontend_input", "Visual Swatch"); // stepKey: fillInputType
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch1WaitForPageLoad
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch2WaitForPageLoad
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch3
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch3WaitForPageLoad
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatches-visual-col"); // stepKey: clickSwatch3
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatches-visual-col"); // stepKey: clickSwatch2
		$I->seeElement("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatches-visual-col .swatch_sub-menu_container"); // stepKey: seeSwatch2
		$I->dontSeeElement("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatches-visual-col .swatch_sub-menu_container"); // stepKey: dontSeeSwatch3
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatches-visual-col"); // stepKey: clickSwatch1
		$I->seeElement("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatches-visual-col .swatch_sub-menu_container"); // stepKey: seeSwatch1
		$I->dontSeeElement("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatches-visual-col .swatch_sub-menu_container"); // stepKey: dontSeeSwatch2
	}
}
