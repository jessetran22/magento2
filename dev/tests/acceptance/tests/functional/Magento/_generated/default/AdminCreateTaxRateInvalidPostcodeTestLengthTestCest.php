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
 * @Title("MC-18817: Create tax rate, invalid post code length")
 * @Description("Test log in to Create Tax Rate and Create Tax Rate with invalid post code length<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminCreateTaxRateInvalidPostcodeTestLengthTest.xml<br>")
 * @TestCaseId("MC-18817")
 * @group tax
 * @group mtf_migrated
 */
class AdminCreateTaxRateInvalidPostcodeTestLengthTestCest
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
	 * @Stories({"Create tax rate"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Tax"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateTaxRateInvalidPostcodeTestLengthTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex1
		$I->comment("Exiting Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Create a tax rate for large postcodes");
		$I->click("#add"); // stepKey: clickAddNewTaxRateButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRateButtonWaitForPageLoad
		$I->fillField("#code", "Tax Rate " . msq("taxRateWithInvalidPostCodeLength")); // stepKey: fillRuleName
		$I->fillField("#tax_postcode", "12345678901"); // stepKey: fillPostCode
		$I->selectOption("#tax_country_id", "United States"); // stepKey: selectCountry1
		$I->selectOption("#tax_region_id", "California"); // stepKey: selectState
		$I->fillField("#rate", "100.0000"); // stepKey: fillRate
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->see("Please enter less or equal than 10 symbols.", "//input[@name='tax_postcode']/following-sibling::label[@class='mage-error']"); // stepKey: seeErrorMessage
	}
}
